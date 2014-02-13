<?php 
$f3 = \Base::instance();
$global_app_name = $f3->get('APP_NAME');

switch ($global_app_name) 
{
    case "admin":
        // register event listener
        \Dsc\System::instance()->getDispatcher()->addListener(\Redirect\Listener::instance());

        // register all the routes
        
        // append this app's UI folder to the path
        $ui = $f3->get('UI');
        $ui .= ";" . $f3->get('PATH_ROOT') . "vendor/dioscouri/f3-redirect/src/Redirect/Admin/Views/";
        $f3->set('UI', $ui);
        
        // TODO set some app-specific settings, if desired
                
        break;
    case "site":        
        // append this app's UI folder to the path
        $ui = $f3->get('UI');
        $ui .= ";" . $f3->get('PATH_ROOT') . "vendor/dioscouri/f3-redirect/src/Redirect/Site/Views/";
        $f3->set('UI', $ui);
                
        // TODO set some app-specific settings, if desired
        break;
}
?>
