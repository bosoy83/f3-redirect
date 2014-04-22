<?php
namespace Redirect;

class Routes extends \Dsc\Routes\Group
{
    /**
     * Initializes all routes for this group
     * NOTE: This method should be overriden by every group
     */
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
    }
}