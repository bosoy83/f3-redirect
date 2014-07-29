<?php
namespace Redirect\Admin\Models;

class Routes extends \Dsc\Mongo\Collections\Nodes
{

    protected $__collection_name = 'redirect.routes';
    protected $__type = 'redirect.routes';

    protected $__config = array(
        'default_sort' => array(
            'last_hit.time' => -1
        )
    );

    public $title;

    public $url = array(
        'alias' => null,
        'redirect' => null
    );

    public $hits; // number of times this route has been hit
    public $last_hit; // \Dsc\Mongo\Metastamp. the last time this route was hit

    protected function fetchConditions()
    {
        parent::fetchConditions();
        
        $filter_keyword = $this->getState('filter.keyword');
        if ($filter_keyword && is_string($filter_keyword))
        {
            $key = new \MongoRegex('/' . $filter_keyword . '/i');
            
            $where = array();
            $where[] = array(
                'title' => $key
            );
            $where[] = array(
                'url.alias' => $key
            );
            $where[] = array(
                'url.redirect' => $key
            );
            
            $this->setCondition('$or', $where);
        }
        
        $filter_id = $this->getState('filter.id');
        if (strlen($filter_id))
        {
            $this->setCondition('_id', new \MongoId((string) $filter_id));
        }
        
        $filter_title = $this->getState('filter.title');
        if (strlen($filter_title))
        {
            $this->setCondition('title', new \MongoRegex('/' . $filter_title . '/i'));
        }
        
        $filter_url_alias = $this->getState('filter.url.alias');
        if (strlen($filter_url_alias))
        {
        	$pattern = $filter_url_alias;
        	if( strpos( $pattern, '/' ) === 0 ){
        		$pattern = substr($pattern, 1 );
        	}
        	
        	$pattern = str_replace( '/', '\/', $pattern );
            $this->setCondition('url.alias', new \MongoRegex( '/(\/)?' . $pattern . '/' ) );
        }
        
        $filter_ids = $this->getState('filter.ids');
        if (!empty($filter_ids) && is_array($filter_ids))
        {
            $ids = array();
            foreach ($filter_ids as $filter_id)
            {
                $ids[] = new \MongoId((string) $filter_id);
            }
            $this->setCondition('_id', array(
                '$in' => $ids
            ));
        }
        
        return $this;
    }

    public function validate()
    {
        if (empty($this->title))
        {
            $this->title = $this->{'url.alias'};
        }
        
        if (empty($this->{'url.alias'}))
        {
            $this->setError('Alias URL is required');
        }
        
        // is the original URL unique?
        if ($this->collection()->count(array(
            'url.alias' => ($this->{'url.alias'}),
            '_id' => array(
                '$ne' => $this->id
            )
        )) > 0)
        {
            $this->setError('Redirection for this route already exists.');
        }
        
        return parent::validate();
    }

    public function beforeSave()
    {
        if (isset($this->url) && is_array($this->url))
        {
            $this->url['alias'] = $this->inputFilter()->clean($this->url['alias'], 'string');
            $this->url['redirect'] = $this->inputFilter()->clean($this->url['redirect'], 'string');
        }
        else
        {
            $this->setError('Missing information about redirection');
        }
        
        return parent::beforeSave();
    }
}