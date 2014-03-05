<?php 
abstract class BaseBootstrap{

	protected $namespace = '';
	
	public function command( $name, $app ){
		$app = ucwords($app);
		if( method_exists( $this, $name.$app ) ){
			$func = $name.$app;
			$this->$func();
		} else if( method_exists( $this, $name ) ){
			$this->$name( $app );
		}
	}
	
	protected function run($app){
		// handle other types of application, if no specific function defined
	}
	
	protected function runAdmin(){
		$listener = "\\".$this->namespace."\\Listener";
		$router = "\\".$this->namespace."\\Routes";
		if( !class_exists($router)){
			$router = "\\".$this->namespace."\\Admin\\Routes";
			if( !class_exists($router)){
				$router = '';
			}
		}
		
		if( class_exists( $listener ) ){
			// register event listener
			\Dsc\System::instance()->getDispatcher()->addListener($listener::instance());
		}
		
		if( strlen( $router ) ) {
			// register all the routes
			\Dsc\System::instance()->get('router')->mount( new $router, $this->namespace );
		}
		
		// append this app's UI folder to the path
		// new way
		\Dsc\System::instance()->get('theme')->registerViewPath( __dir__ . '/src/'.$this->namespace.'/Admin/Views/', $this->namespace.'/Admin/Views' );
	}
	
	protected function preRun($app){
		// handle other types of application, if no specific function defined
	}
	
	protected function preRunAdmin(){
	}
	
	protected function postRun($app){
		// handle other types of application, if no specific function defined
	}
	
	protected function postRunAdmin(){
	}
}


class RedirectBootstrap extends BaseBootstrap{
	protected $namespace = 'Redirect';
}

$f3 = \Base::instance();
$global_app_name = $f3->get('APP_NAME');

switch ($global_app_name) 
{
    case "admin":
    	$test = new RedirectBootstrap();
    	$test->command( "pre",  $global_app_name);
    	$test->command( "run",  $global_app_name);
    	$test->command( "post",  $global_app_name);
/*    	
        // register event listener
        \Dsc\System::instance()->getDispatcher()->addListener(\Redirect\Listener::instance());

        // register all the routes        
        \Dsc\System::instance()->get('router')->mount( new \Redirect\Routes, 'redirect' );
        
        // append this app's UI folder to the path
        // new way
        \Dsc\System::instance()->get('theme')->registerViewPath( __dir__ . '/src/Redirect/Admin/Views/', 'Redirect/Admin/Views' );
        
        // TODO set some app-specific settings, if desired
*/                
        break;
    case "site":        
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
        // TODO set some app-specific settings, if desired
        break;
}
?>
