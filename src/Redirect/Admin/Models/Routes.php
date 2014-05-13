<?php 
namespace Redirect\Admin\Models;

class Routes extends \Dsc\Mongo\Collection
{
	protected $__collection_name= 'redirect.routes';
	protected $__config = array(
			'default_sort' => array(
					'title' => 1
			),
	);
	
	public $title;
	public $url = array(
		'alias' => null,
	    'redirect' => null
	);
	public $hits;          // number of times this route has been hit
	public $last_hit;      // \Dsc\Mongo\Metastamp.  the last time this route was hit
	public $metadata = array(
	    'creator'=>null,
	    'created'=>null,
	    'last_modified'=>null
	);	
	
	protected function fetchConditions()
	{
		parent::fetchConditions();
	
		$filter_keyword = $this->getState('filter.keyword');
		if ($filter_keyword && is_string($filter_keyword))
		{
			$key =  new \MongoRegex('/'. $filter_keyword .'/i');
	
			$where = array();
			$where[] = array('title'=>$key);
			$where[] = array('url.alias'=>$key);
			$where[] = array('url.redirect'=>$key);
	
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
			$this->setCondition('title', new \MongoRegex('/'. $filter_title .'/i'));
		}
		
		$filter_url_alias = $this->getState('filter.url.alias');
		if (strlen($filter_url_alias))
		{
			$this->setCondition('url.alias', $filter_url_alias);
		}
		
		$filter_ids = $this->getState('filter.ids');
		if (!empty($filter_ids) && is_array($filter_ids))
		{
			$ids = array();
			foreach ($filter_ids as $filter_id) {
				$ids[] = new \MongoId((string) $filter_id);
			}
			$this->setCondition('_id', array('$in' => $ids));
		}
	
		return $this;
	}
	
    public function validate()
    {
        if (empty($this->title)) {
            $this->title = $this->{'url.alias'};
        }

        if (empty($this->{'url.alias'})) {
        	$this->setError('Alias URL is required');
        }
        
        // is the original URL unique?
        if ($this->collection()->count( array( 
			        		'url.alias' => ($this->{'url.alias'} ),
			        		'_id' => array( '$ne' => $this->id) 
        									))  > 0 ) 
        {
			$this->setError('Redirection for this route already exists.');
        }

        return parent::validate();
    }
    
    public function beforeSave()
    {
    	if( isset( $this->url ) && is_array($this->url)){
    		$this->url['alias'] = $this->inputFilter()->clean( $this->url['alias'], 'string' );
    		$this->url['redirect'] = $this->inputFilter()->clean( $this->url['redirect'], 'string' );
    	} else {
    		$this->setError( 'Missing information about redirection' );
    	}
    	
    	if (!$this->get('metadata.creator'))
    	{
    	    $identity = \Dsc\System::instance()->get('auth')->getIdentity();
    	    if (!empty($identity->id))
    	    {
    	        $this->set('metadata.creator', array(
    	            'id' => $identity->id,
    	            'name' => $identity->fullName()
    	        ));
    	    }
    	    else
    	    {
    	        $this->set('metadata.creator', array(
    	            'id' => \Base::instance()->get('safemode.id'),
    	            'name' => \Base::instance()->get('safemode.username')
    	        ));
    	    }
    	}
    	
        if (!$this->get('metadata.created'))
        {
        	$this->set('metadata.created', \Dsc\Mongo\Metastamp::getDate('now') );
        }
        
        $this->set('metadata.last_modified', \Dsc\Mongo\Metastamp::getDate('now') );

    	return parent::beforeSave();
    }
}