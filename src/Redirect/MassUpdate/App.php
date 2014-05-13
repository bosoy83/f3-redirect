<?php
namespace Redirect\MassUpdate;

class App extends \MassUpdate\Service\Models\App{

	protected $name = 'Redirect';
	public $title = 'Route Manager';
	
	/**
	 * Initialize list of models
	 *
	 * @param	$mode	Mode of updater
	 * 
	 * @return	Whether the list was initialized or not (in case the app is not available)
	 */
	public function initialize($mode) {
		$result = parent::initialize($mode);
		if( $result ) {
			$this->addModel( new \Redirect\MassUpdate\Models\Routes );
			return true;
		}
		return false;
	}	
}

$app = new \Redirect\MassUpdate\App();