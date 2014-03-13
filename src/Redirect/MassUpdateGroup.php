<?php 
namespace Redirect;

class MassUpdateGroup extends \MassUpdate\Service\Models\Group{
	
	public $title = 'Route Manager';
	
	public $slug = 'redirect';
	
	/**
	 * Initialize list of models
	 * 
	 * @param	$mode	Mode of updater
	 */
	public function initialize( $mode ) {
		$this->addModel( new \Redirect\Admin\Models\Routes, $mode );
	}
}
?>