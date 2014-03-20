<?php 

class RedirectBootstrap extends \Dsc\Bootstrap{
	protected $dir = __DIR__;
	protected $namespace = 'Redirect';

	protected function runAdmin(){
		parent::runAdmin();
		try{
			$service = \Dsc\System::instance()->get('massupdate');
			if( !empty( $service ) ){
				$service->registerGroup( new \Redirect\MassUpdateGroup );
			}
		} catch( \Exception $e){}
	}
	
	protected function runSite(){
		$f3 = \Base::instance();
		$f3->set('ONERROR',
				function($f3) {
					 
					if($f3->get('ERROR.code') == '404')  {
						// lets find a proper redirection, if exists
						$model = new \Redirect\Admin\Models\Routes;
						$path = substr( $model->inputFilter()->clean($f3->hive()['PATH'], 'string'), 1 );
						$model->populateState()->setState( 'filter.url.alias', $path);
						$routes = $model->getItems();
						if( count( $routes ) == 1 ) {
							$f3->reroute( '/'.$routes[0]->{'url.redirect'});
						} else { // use default error route
							$model = new \Redirect\Admin\Models\Settings;
							$model->populateState();
							$list = $model->getItems();
							if( count($list ) == 1 ){
								$redirect = $list[0]->{'general.default_error_404'};
								if( $path != $redirect ) {
									$f3->reroute( '/'.$list[0]->{'general.default_error_404'} );
								} else {
									// exploring infinite universe is fun, but not today
									$f3->reroute( '/' );
								}
							} else {
								// dude, now you're really out of it
								$f3->reroute( '/' );
							}
						}
						 
					}
					 
				}
		);
		
	}
}
$app = new RedirectBootstrap();