<?php
namespace Redirect\Admin\Controllers;

class Export extends \Admin\Controllers\BaseAuth
{
    public function beforeRoute()
    {
        $this->app->set('meta.title', 'Export | Redirect');
    }

    public function index()
    {
        $this->app->set('meta.title', 'Export | Redirect');
        
        echo $this->theme->render('Redirect/Admin/Views::export/index.php');
    }
    
    public function all()
    {
        $time = time();
        $filename = \Base::instance()->get('PATH_ROOT') . 'tmp/' . $time . '.csv';
        
        $writer = (new \Ddeboer\DataImport\Writer\CsvWriter(","))->setStream(fopen($filename, 'w'));
        
        // Write column headers:
        $writer->writeItem(array(
            'id',
            'alias',
            'redirect'
        ));
        
        // write items
        $cursor = (new \Redirect\Admin\Models\Routes)->collection()->find(array(), array(
            '_id' => 1,
            'url' => 1
        ));
        
        foreach ($cursor as $doc)
        {
            $writer->writeItem(array(
                $doc['_id'],
                @$doc['url']['alias'],
                @$doc['url']['redirect'],
            ));
        }
        
        \Web::instance()->send($filename, null, 0, true);
    }
}