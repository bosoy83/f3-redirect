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
            $mapper->title = 'Redirects';
            $mapper->route = '';
            $mapper->icon = 'fa fa-external-link';
            $mapper->children = array(
                    json_decode(json_encode(array( 'title'=>'List', 'route'=>'/admin/redirect/routes', 'icon'=>'fa fa-list' )))
                    ,json_decode(json_encode(array( 'title'=>'Settings', 'route'=>'/admin/redirect/settings', 'icon'=>'fa fa-cogs' )))
            );
            $mapper->save();
            
            \Dsc\System::instance()->addMessage('Routes Manager added its admin menu items.');
        }
    }
}