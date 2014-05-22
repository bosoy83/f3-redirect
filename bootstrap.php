<?php

class RedirectBootstrap extends \Dsc\Bootstrap
{

    protected $dir = __DIR__;

    protected $namespace = 'Redirect';

    protected function preAdmin()
    {
        parent::preAdmin();
        
        \Dsc\Apps::registerPath($this->dir . "/src/Redirect/MassUpdate", 'massupdate');
    }

    protected function runSite()
    {
        $f3 = \Base::instance();
        $f3->set('ONERROR', function ($f3)
        {
            $response = \Redirect\Factory::handleError();
            
            // Run the response through a Listener event
            $event = \Dsc\System::instance()->trigger( 'onError', array(
            	'response' => $response
            ) );
            
            $response = $event->getArgument('response');
            
            switch ($response->action)
            {
            	case "handle":
            	    $f3->call($response->callable_handle);
            	    break;
            	case "html":
            	    echo $response->html;
            	    break;
            	case "redirect":
            	    $f3->reroute( $response->redirect_route );
            	    break;
            	default:
            	    // by returning false, let f3 default error handler handle the error
            	    return false;
            	    break;
            }
        });
    }
}
$app = new RedirectBootstrap();