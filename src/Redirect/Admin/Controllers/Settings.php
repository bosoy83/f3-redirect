<?php 
namespace Redirect\Admin\Controllers;

class Settings extends \Admin\Controllers\BaseAuth 
{
	use \Dsc\Traits\Controllers\Settings;
	
	protected $layout_link = 'Redirect/Admin/Views::settings/default.php';
	protected $settings_route = '/admin/redirect/settings';
    
    protected function getModel()
    {
        $model = new \Redirect\Admin\Models\Settings;
        return $model;
    }
}