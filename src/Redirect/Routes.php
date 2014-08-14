<?php
namespace Redirect;

class Routes extends \Dsc\Routes\Group
{

    public function initialize()
    {
        $this->setDefaults(array(
            'namespace' => '\Redirect\Admin\Controllers',
            'url_prefix' => '/admin/redirect'
        ));
        
        $this->addSettingsRoutes();
        
        $this->addCrudGroup('Routes', 'Route', array(
            'datatable_links' => true
        ));
        
        $this->add( '/import', 'GET', array(
            'controller' => 'Importer',
            'action' => 'index'
        ) );
        
        $this->add( '/import/handleUpload', 'POST', array(
            'controller' => 'Importer',
            'action' => 'handleUpload'
        ) );        
        
        $this->add( '/import/preview/@id', 'GET', array(
            'controller' => 'Importer',
            'action' => 'preview'
        ) );

        $this->add( '/import/routes/@id', 'GET', array(
            'controller' => 'Importer',
            'action' => 'routes'
        ) );        
        
        $this->app->route( 'GET /admin/redirect/import/@task', '\Redirect\Admin\Controllers\Importer->@task' );        
    }
}