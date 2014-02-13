<?php 
namespace Redirect;

class Listener extends \Prefab 
{
    public function onSystemRebuildMenu( $event )
    {
        if ($mapper = $event->getArgument('mapper')) 
        {
            $mapper->reset();
            $mapper->priority = 40;
            $mapper->id = 'f3-redirect';
            $mapper->title = 'Routes Manager';
            $mapper->route = '';
            $mapper->icon = 'fa fa-external-link';
            $mapper->children = array(
                    json_decode(json_encode(array( 'title'=>'Routes', 'route'=>'/admin/routes', 'icon'=>'fa fa-list' )))
                    ,json_decode(json_encode(array( 'title'=>'Add New', 'route'=>'/admin/route', 'icon'=>'fa fa-plus' )))
            );
            $mapper->save();
            
            \Dsc\System::instance()->addMessage('Routes Manager added its admin menu items.');
        }
    }
}