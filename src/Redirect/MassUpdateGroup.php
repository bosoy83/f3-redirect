<?php 
namespace Redirect;

class MassUpdateGroup extends \MassUpdate\Service\Models\Group{
	
	public $title = 'Route Manager';

	/**
	 * Initialize list of models
	 * 
	 * @param	$mode	Mode of updater
	 */
	public function initialize($mode) {
		parent::initialize($mode);
		$this->addModel( new \Redirect\Admin\Models\Routes );
	}
}
?>