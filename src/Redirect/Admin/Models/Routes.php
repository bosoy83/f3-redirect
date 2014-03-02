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
	
	// strict document format
	public $_id;
	public $title;
	public $url = array(); // array having two elements -> original and redirect
	
	protected function fetchConditions()
	{
		parent::fetchConditions();
	
		$filter_keyword = $this->getState('filter.keyword');
		if ($filter_keyword && is_string($filter_keyword))
		{
			$key =  new \MongoRegex('/'. $filter_keyword .'/i');
	
			$where = array();
			$where[] = array('title'=>$key);
			$where[] = array('url.original'=>$key);
			$where[] = array('urlredirect'=>$key);
	
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
			$this->setCondition('title', $filter_title);
		}
		
		$filter_url_original = $this->getState('filter.url.original');
		if (strlen($filter_title))
		{
			$this->setCondition('url.original', $filter_url_original);
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
            $this->setError('Title is required');
        }

        if (empty($this->{'url.original'})) {
        	$this->setError('Original URL is required');
        }

        if (empty($this->{'url.redirect'})) {
        	$this->setError('New Redirection is required');
        }
        
        // is the original URL unique?
        if ($this->collection()->count( array( 'original' => $this->{'url.original'} )) > 0 ) 
        {
			$this->setError('Redirection for this route already exists.');
        }

        return parent::validate();
    }
}