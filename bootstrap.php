<?php 
$f3 = \Base::instance();
$global_app_name = $f3->get('APP_NAME');

switch ($global_app_name) 
{
    case "admin":
        // register event listener
        \Dsc\System::instance()->getDispatcher()->addListener(\Redirect\Listener::instance());

        // register all the routes
        $f3->route('GET|POST /admin/routes', '\Redirect\Admin\Controllers\Routes->display');
        $f3->route('GET|POST /admin/routes/delete', '\Redirect\Admin\Controllers\Routes->delete');
        $f3->route('GET /admin/route', '\Redirect\Admin\Controllers\Route->create');
        $f3->route('POST /admin/route', '\Redirect\Admin\Controllers\Route->add');
        $f3->route('GET /admin/route/@id', '\Redirect\Admin\Controllers\Route->read');
        $f3->route('GET /admin/route/edit/@id', '\Redirect\Admin\Controllers\Route->edit');
        $f3->route('POST /admin/route/@id', '\Redirect\Admin\Controllers\Route->update');
        $f3->route('DELETE /admin/route/@id', '\Redirect\Admin\Controllers\Route->delete');
        $f3->route('GET /admin/route/delete/@id', '\Redirect\Admin\Controllers\Route->delete');        
        
        // append this app's UI folder to the path
        $ui = $f3->get('UI');
        $ui .= ";" . $f3->get('PATH_ROOT') . "vendor/dioscouri/f3-redirect/src/Redirect/Admin/Views/";
        $f3->set('UI', $ui);
        
        // TODO set some app-specific settings, if desired
                
        break;
    case "site":        
		$f3->set('ONERROR',
            function($f3) {
               
               if($f3->get('ERROR.code') == '404')  {
//                $redirect = (new \Redirect\Factory($PARAMS[0]))->redirect();

               }
               
            }
        );
        // TODO set some app-specific settings, if desired
        break;
}
?>
