<?php 
namespace Redirect\Admin\Controllers;

class Routes extends \Admin\Controllers\BaseAuth
{
    protected function getModel()
    {
        $model = new \Redirect\Admin\Models\Routes;
        $model->populateState();
        $model->setParam( 'skip', $model->getState('list.offset', 0) );
        $model->setParam( 'limit', $model->getState('list.limit', 0) );
        print_r( $model->getState('list.limit', 0) );
        return $model;
    }
	
	public function index()
    {
        \Base::instance()->set('pagetitle', 'Routes');
        \Base::instance()->set('subtitle', '');
        
        $model = $this->getModel();
        $state = $model->populateState()->setState('filter.type', true)->getState();
        \Base::instance()->set('state', $state );
        \Base::instance()->set('pagination' ,$model->paginate() );
        \Base::instance()->set('list' ,$model->getItems() );
        
        echo \Dsc\System::instance()->get('theme')->render('Redirect/Admin/Views::routes/list.php');
    }    

    
    public function getDatatable()
    {
        $model = $this->getModel();
        
        $state = $model->populateState()->getState();
        \Base::instance()->set('state', $state );
        
        \Base::instance()->set('pagination', $model->paginate() );
        \Base::instance()->set('list', $model->getItems() );
        $html = \Dsc\System::instance()->get('theme')->renderLayout('Redirect/Admin/Views::routes/list_datatable.php');
        
        return $this->outputJson( $this->getJsonResponse( array(
                'result' => $html
        ) ) );
    
    }
}