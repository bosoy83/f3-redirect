<?php 
$f3 = \Base::instance();
$global_app_name = $f3->get('APP_NAME');

switch ($global_app_name) 
{
    case "admin":
        // register event listener
        \Dsc\System::instance()->getDispatcher()->addListener(\Redirect\Listener::instance());

        // register all the routes
        $f3->route('GET /admin/redirect/routes [ajax]','\Redirect\Admin\Controllers\Routes->getDatatable');
        $f3->route('GET|POST /admin/redirect/routes', '\Redirect\Admin\Controllers\Routes->display');
        $f3->route('GET|POST /admin/redirect/routes/delete', '\Redirect\Admin\Controllers\Routes->delete');
        
        $f3->route('GET /admin/redirect/route', '\Redirect\Admin\Controllers\Route->create');
        $f3->route('POST /admin/redirect/route', '\Redirect\Admin\Controllers\Route->add');
        $f3->route('POST /admin/redirect/route/add', '\Redirect\Admin\Controllers\Route->add');
        $f3->route('GET /admin/redirect/route/@id/read', '\Redirect\Admin\Controllers\Route->read');
        $f3->route('GET /admin/redirect/route/@id/edit', '\Redirect\Admin\Controllers\Route->edit');
        $f3->route('POST /admin/redirect/route/@id/update', '\Redirect\Admin\Controllers\Route->update');
        $f3->route('DELETE /admin/redirect/route/@id', '\Redirect\Admin\Controllers\Route->delete');
        $f3->route('GET /admin/redirect/route/@id/delete', '\Redirect\Admin\Controllers\Route->delete');        
        
        // append this app's UI folder to the path
        // new way
        \Dsc\System::instance()->get('theme')->registerViewPath( __dir__ . '/src/Redirect/Admin/Views/', 'Redirect/Admin/Views' );
        // old way
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
