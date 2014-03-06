<?php 
namespace Redirect;

class MassUpdateGroup extends \MassUpdate\Service\Models\Group{
	
	public $title = 'Route Manager';
	
	public $slug = 'redirect';
	/**
	 * Initialize list of models
	 */
	public function initialize() {
		$this->addModel( new \Redirect\Admin\Models\Routes );
	}
	}
?>