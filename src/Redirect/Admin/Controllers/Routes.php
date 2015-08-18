<?php 
namespace Redirect\Admin\Controllers;

class Routes extends \Admin\Controllers\BaseAuth
{
     protected $list_route = '/admin/redirect/routes';
	
     use \Dsc\Traits\Controllers\AdminList;
	
	protected function getModel()
    {
        $model = new \Redirect\Admin\Models\Routes;
        return $model;
    }
	
	public function index()
    {
        $model = $this->getModel();
        $model->populateState();
        $state = $model->setState('filter.type', true)->setState('filter.noredirect', true)->getState();
        
        $model->setParam( 'skip', $model->getState('list.offset', 0) );
        $model->setParam( 'limit', $model->getState('list.limit', 0) );
        \Base::instance()->set('state', $state );
		\Base::instance()->set( 'paginated', $model->paginate() );

		$this->app->set('meta.title', 'Redirects');
		
        echo \Dsc\System::instance()->get('theme')->render('Redirect/Admin/Views::routes/list.php');
    }    

    
    public function getDatatable()
    {
        $model = $this->getModel();
        
        $state = $model->populateState()->getState();
        \Base::instance()->set('state', $state );
        
        $model->setParam( 'skip', $model->getState('list.offset', 0) );
        $model->setParam( 'limit', $model->getState('list.limit', 0) );
        
		\Base::instance()->set( 'paginated', $model->paginate() );

		$html = \Dsc\System::instance()->get('theme')->renderLayout('Redirect/Admin/Views::routes/list_datatable.php');
        
        return $this->outputJson( $this->getJsonResponse( array(
                'result' => $html
        ) ) );
    
    }
}