<?php 
namespace Redirect\Admin\Models;

class Routes extends \Dsc\Mongo\Collection
{
	protected $__collection_name= 'redirect.routes';
	
	// strict document format
	public $_id;
	public $title;
	public $url = array(); // array having two elements -> original and redirect
	
	    
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