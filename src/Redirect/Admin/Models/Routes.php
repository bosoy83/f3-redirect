<?php 
namespace Redirect\Admin\Models;

class Routes extends \Dsc\Models\Content
{
	protected $type = 'redirect.routes';
    
    protected function fetchFilters()
    {
        $this->filters = parent::fetchFilters();
    
        $this->filters['metadata.type'] = $this->type;
        
        return $this->filters;
    }
	
}