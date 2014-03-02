<?php

namespace Redirect;

/**
 * Group class is used to keep track of a group of routes with similar aspects (the same controller, the same f3-app and etc)
 * 
 * @author Lukas Polak
 */
class Routes extends \Dsc\Routes\Group{
	
	
	function __construct(){
		parent::__construct();
	}
	
	/**
	 * Initializes all routes for this group
	 * NOTE: This method should be overriden by every group
	 */
	public function initialize(){
		$this->setDefaults(
				array(
					'namespace' => '\Redirect\Admin\Controllers',
					'url_prefix' => '/admin/redirect'
				)
		);
		
		$this->addSettingsRoutes();
		$this->add( '/routes', 'GET', array(
										'controller' => 'Routes',
										'action' => 'getDatatable',
										'ajax' => 'true'
										));
		$this->addCrudList( 'Routes' );
		$this->addCrudItem( 'Route' );
	}
}