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
		
		$this->add( '/routes', 'GET', array(
										'controller' => 'Routes',
										'action' => 'getDatatable',
										'ajax' => 'true'
										));

		$this->add( '/routes', array('GET', 'POST'), array(
				'controller' => 'Routes',
				'action' => 'display'
		));

		$this->add( '/routes/delete', array('GET', 'POST'), array(
				'controller' => 'Routes',
				'action' => 'delete'
		));

		$this->add( '/route', 'GET', array(
				'controller' => 'Route',
				'action' => 'create'
		));
		
		$this->add( '/route', 'POST', array(
				'controller' => 'Route',
				'action' => 'add'
		));
		
		$this->add( '/route', 'POST', array(
				'controller' => 'Route',
				'action' => 'add'
		));
		
		$this->add( '/route/@id/read', 'GET', array(
				'controller' => 'Route',
				'action' => 'read'
		));

		$this->add( '/route/@id/edit', 'GET', array(
				'controller' => 'Route',
				'action' => 'edit'
		));
		

		$this->add( '/route/@id/update', 'POST', array(
				'controller' => 'Route',
				'action' => 'update'
		));		

		$this->add( '/route/@id', 'DELETE', array(
				'controller' => 'Route',
				'action' => 'delete'
		));

		$this->add( '/route/@id/delete', 'GET', array(
				'controller' => 'Route',
				'action' => 'delete'
		));
	}
}