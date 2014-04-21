<?php
class RedirectBootstrap extends \Dsc\Bootstrap
{
    protected $dir = __DIR__;
    protected $namespace = 'Redirect';

    protected function runAdmin()
    {
        parent::runAdmin();
        try
        {
            $service = \Dsc\System::instance()->get( 'massupdate' );
            if (! empty( $service ))
            {
            	$group = new \Redirect\MassUpdateGroup();
            	$group->setName( $this->namespace );
            	$service->registerGroup( $group );
            }
        }
        catch ( \Exception $e )
        {
        }
    }

    protected function runSite()
    {
        $f3 = \Base::instance();
        $f3->set( 'ONERROR', function ( $f3 )
        {
            if ($f3->get( 'ERROR.code' ) == '404')
            {
                $model = new \Redirect\Admin\Models\Routes;

                // lets find a proper redirection, if exists
                $path = substr( $model->inputFilter()->clean( $f3->hive()['PATH'], 'string' ), 1 );

                $redirect = null;
                if ($route = $model->setState( 'filter.url.alias', $path )->getItem()) 
                {
                    // count the number of times a redirect is hit and track the date of the last hit
                    $route->hits = (int) $route->hits + 1;
                    $route->last_hit = \Dsc\Mongo\Metastamp::getDate('now');
                    $route->save();
                                        
                    $redirect = trim( $route->{'url.redirect'} );                	
                }
                // no defined redirect for this $path was found, so create a record in the redirect manager
                else 
                {
                	// TODO add a config option to disable this
                    $new_route = new \Redirect\Admin\Models\Routes;
                    $new_route->set('url.alias', $path);
                    $new_route->hits = 1;
                    $new_route->last_hit = \Dsc\Mongo\Metastamp::getDate('now');
                    try {
                        $new_route->save();
                    } catch (\Exception $e) {
                        // couldn't save for some reason
                        // add it to Logger?                    	
                    }
                }
                
                // don't redirect if the path and redirect are the same to prevent recursion
                if (!empty( $redirect ) && $path != $redirect)
                {
                    // if the string doesn't begin with /, make sure it does
                    if (strpos($redirect, '/') !== 0) {
                        $redirect = '/' . $redirect;
                    }                    
                    $f3->reroute( $redirect );
                }
                else
                { 
                    // use default error route specified by user in Redirect::Settings
                    $settings = \Redirect\Admin\Models\Settings::fetch();
                    $default_redirect = $settings->{'general.default_error_404'};
                    if (!empty($default_redirect) && $path != $default_redirect)
                    {
                        // if the string doesn't begin with /, make sure it does
                        if (strpos($default_redirect, '/') !== 0) {
                            $default_redirect = '/' . $default_redirect;
                        }
                        
                        $f3->reroute( $default_redirect );
                    }
                    else
                    {
                        // let f3 default error handler handle it since the user didn't specify a default 404 redirect
                        return false;
                    }
                }
            }
            else
            {
                // let f3 default error handler handle all other error types
                return false;
            }    
        } );
    }
}
$app = new RedirectBootstrap();