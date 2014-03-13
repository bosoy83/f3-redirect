<?php 
namespace Redirect\Admin\Models\Prefabs;

class Settings extends \Dsc\Prefabs
{
    /**
     * Default document structure
     * @var array
     */
    protected $document = array(
        'general'=>array(
            'default_error_404' => ''
        )
    );
}