<?php 
namespace Redirect\Admin\Models;

class Routes extends \Dsc\Models\Assets
{
	protected $type = 'redirect.routes';
    protected $collection = 'redirect.routes';
    protected $default_ordering_direction = '1';
    protected $default_ordering_field = 'metadata.title';
	    
    protected function fetchFilters()
    {
        $this->filters = parent::fetchFilters();
    
        $this->filters['metadata.type'] = $this->type;
        
        return $this->filters;
    }
	
}