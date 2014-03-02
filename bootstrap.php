<?php 
$f3 = \Base::instance();
$global_app_name = $f3->get('APP_NAME');

switch ($global_app_name) 
{
    case "admin":
        // register event listener
        \Dsc\System::instance()->getDispatcher()->addListener(\Redirect\Listener::instance());

        // register all the routes        
        \Dsc\System::instance()->get('router')->mount( new \Redirect\Routes, 'redirect' );
        
        // append this app's UI folder to the path
        // new way
        \Dsc\System::instance()->get('theme')->registerViewPath( __dir__ . '/src/Redirect/Admin/Views/', 'Redirect/Admin/Views' );
        
        // TODO set some app-specific settings, if desired
                
        break;
    case "site":        
		$f3->set('ONERROR',
            function($f3) {
               
               if($f3->get('ERROR.code') == '404')  {
               		// lets find a proper redirection, if exists
        			$model = new \Redirect\Admin\Models\Routes;
               		$path = substr( $model->inputFilter()->clean($f3->hive()['PATH'], 'string'), 1 );
        			$model->populateState()->setState( 'filter.url.original', $path);
        			$routes = $model->getItems();
        			if( count( $routes ) == 1 ) {
        				$f3->reroute( '/'.$routes[0]->{'url.redirect'});
        			}
               }
               
            }
        );
        // TODO set some app-specific settings, if desired
        break;
}
?>
