<?php 
namespace Redirect;

class Listener extends \Prefab 
{
    public function onSystemRebuildMenu( $event )
    {
        if ($model = $event->getArgument('model')) 
        {
        	$root = $event->getArgument( 'root' );
        	$redirect = clone $model;

        	$redirect->insert(
        			array(
        					'type'	=> 'admin.nav',
        					'priority' => 90,
        					'title'	=> 'Redirects',
        					'icon'	=> 'fa fa-external-link',
        					'is_root' => false,
        					'tree'	=> $root,
							'base' => '/admin/redirect/',
        			)
        	);
        	
            $children = array(
                    array( 'title'=>'List', 'route'=>'/admin/redirect/routes', 'icon'=>'fa fa-list' ),
                    array( 'title'=>'Settings', 'route'=>'/admin/redirect/settings', 'icon'=>'fa fa-cogs' ),
            );
           	$redirect->addChildrenItems( $children, $root );
            
            \Dsc\System::instance()->addMessage('Routes Manager added its admin menu items.');
        }
    }
}