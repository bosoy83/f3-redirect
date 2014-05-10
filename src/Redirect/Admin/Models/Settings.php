<?php 
namespace Redirect\Admin\Models;

class Settings extends \Dsc\Mongo\Collections\Settings
{
    protected $__type = 'redirect.settings';

    public $general = array(
    				'default_error_404' => ''
    		);
}