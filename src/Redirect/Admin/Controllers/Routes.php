<?php 
namespace Redirect\Admin\Controllers;

class Routes extends \Admin\Controllers\Base
{
    public function display()
    {
        \Base::instance()->set('pagetitle', 'Routes');
        \Base::instance()->set('subtitle', '');
        
        $model = new \Redirect\Admin\Models\Routes;
        $state = $model->populateState()->setState('filter.type', true)->getState();
        \Base::instance()->set('state', $state );
        
        $list = $model->paginate();
        \Base::instance()->set('list', $list );
        
        $pagination = new \Dsc\Pagination($list['total'], $list['limit']);       
        \Base::instance()->set('pagination', $pagination );
        
        $view = new \Dsc\Template;
        echo $view->render('Redirect/Admin/Views::routes/list.php');
    }    
}