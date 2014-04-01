<?php 
namespace Redirect\Admin\Models;

class Settings extends \Dsc\Mongo\Collections\Settings
{
    protected $type = 'redirect.settings';
    
    public function prefab( $source=array(), $options=array() )
    {
        $prefab = new \Redirect\Admin\Models\Prefabs\Settings($source, $options);
    
        return $prefab;
    }
    
    /**
     * An alias for the save command, used only for creating a new object
     *
     * @param array $values
     * @param array $options
     */
    public function create( $values, $options=array() )
    {
        $values = array_merge( $this->prefab()->cast(), $values );
    
        return $this->save( $values, $options );
    }
}