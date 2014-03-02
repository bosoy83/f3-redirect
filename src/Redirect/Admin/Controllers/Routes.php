<?php 
namespace Redirect\Admin\Controllers;

class Routes extends \Admin\Controllers\BaseAuth
{
    protected function getModel()
    {
        $model = new \Redirect\Admin\Models\Routes;
        return $model;
    }
	
	public function index()
    {
        \Base::instance()->set('pagetitle', 'Routes');
        \Base::instance()->set('subtitle', '');
        
        $model = $this->getModel();
        $model->populateState();
        $state = $model->setState('filter.type', true)->getState();
        $model->setParam( 'skip', $model->getState('list.offset', 0) );
        $model->setParam( 'limit', $model->getState('list.limit', 0) );
        \Base::instance()->set('state', $state );
//        \Base::instance()->set('pagination' ,$model->paginate() );
		\Base::instance()->set( 'paginated', $model->paginate() );
//        \Base::instance()->set('list' ,$model->getItems() );
        
        echo \Dsc\System::instance()->get('theme')->render('Redirect/Admin/Views::routes/list.php');
    }    

    
    public function getDatatable()
    {
        $model = $this->getModel();
        
        $state = $model->populateState()->getState();
        \Base::instance()->set('state', $state );
        $model->setParam( 'skip', $model->getState('list.offset', 0) );
        $model->setParam( 'limit', $model->getState('list.limit', 0) );
        
        \Base::instance()->set('pagination', $model->paginate() );
        \Base::instance()->set('list', $model->getItems() );
        $html = \Dsc\System::instance()->get('theme')->renderLayout('Redirect/Admin/Views::routes/list_datatable.php');
        
        return $this->outputJson( $this->getJsonResponse( array(
                'result' => $html
        ) ) );
    
    }
}