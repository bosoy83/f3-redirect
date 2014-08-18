<?php
namespace Redirect\Admin\Controllers;

class Importer extends \Admin\Controllers\BaseAuth
{
    public function beforeRoute()
    {
        $this->app->set('meta.title', 'Importer | Redirect');
    }

    public function index()
    {
        $this->app->set('meta.title', 'Importer | Redirect');
        
        echo $this->theme->render('Redirect/Admin/Views::importer/index.php');
    }

    /**
     * Target for the upload handler
     */
    public function handleUpload()
    {
        try {
            $files = $this->app->get("FILES");
            $model = \Dsc\Mongo\Collections\Assets::createFromUpload($files['import_file'], array('type'=>'redirect.importer'));
            $this->app->reroute("/admin/redirect/import/preview/" . $model->id );
        }
        catch (\Exception $e) 
        {
            \Dsc\System::addMessage( $e->getMessage(), 'error' );
            $this->app->reroute("/admin/redirect/import");
        }
    }

    /**
     * Preview the data in an uploaded file
     * 
     * @throws \Exception
     */
    public function preview()
    {
        try 
        {
            $id = $this->inputfilter->clean( $this->app->get('PARAMS.id'), 'alnum' );
            $item = (new \Dsc\Mongo\Collections\Assets)->setState('filter.id', $id)->getItem();
            if (empty($item->id)) {
                throw new \Exception('Invalid Item');    	
            }
            
            $file = new \SplTempFileObject();
            
            // TODO Push this to the Assets model
            switch ($item->storage)
            {
                case "s3":
                    $contents = @file_get_contents( $item->url );
            
                    break;
                case "gridfs":
                default:
            
                    $length = $item->length;
                    $chunkSize = $item->chunkSize;
                    $chunks = ceil( $length / $chunkSize );
            
                    $collChunkName = $item->collectionNameGridFS() . ".chunks";
                    $collChunks = $item->getDb()->{$collChunkName};
            
                    $contents = null;
                    for( $i=0; $i<$chunks; $i++ )
                    {
                        $chunk = $collChunks->findOne( array( "files_id" => $item->_id, "n" => $i ) );
                        $contents .=  $chunk["data"]->bin;
                    }
            
                    break;
            }
            
            $file->fwrite($contents);
            
            
            $reader = new \Ddeboer\DataImport\Reader\CsvReader($file, ",");
            $reader->setHeaderRowNumber(0);
            $reader->rewind();
            
        } 
        catch ( \Exception $e ) 
        {
            \Dsc\System::instance()->addMessage( $e->getMessage(), 'error');
            $this->app->reroute('/admin/redirect/import');
            return;
        }
        
        $first_row = $reader->current();
        $preview = \Dsc\Debug::dump( $first_row );
        $this->app->set('preview', $preview);
        $this->app->set('count', count($reader));

        $this->app->set('item', $item);
        
        echo $this->theme->render('Redirect/Admin/Views::importer/preview.php');
    }
    
    /**
     * Import routes from a specified Asset ID
     * 
     * @throws \Exception
     */
    public function routes()
    {
        $message = null;
        
        try 
        {
            $id = $this->inputfilter->clean( $this->app->get('PARAMS.id'), 'alnum' );
            $item = (new \Dsc\Mongo\Collections\Assets)->setState('filter.id', $id)->getItem();
            if (empty($item->id)) {
                throw new \Exception('Invalid Item');    	
            }
            
            $file = new \SplTempFileObject();
            // TODO Push this to the Assets model
            switch ($item->storage)
            {
                case "s3":
                    $contents = @file_get_contents( $item->url );
            
                    break;
                case "gridfs":
                default:
            
                    $length = $item->length;
                    $chunkSize = $item->chunkSize;
                    $chunks = ceil( $length / $chunkSize );
            
                    $collChunkName = $item->collectionNameGridFS() . ".chunks";
                    $collChunks = $item->getDb()->{$collChunkName};
            
                    $contents = null;
                    for( $i=0; $i<$chunks; $i++ )
                    {
                        $chunk = $collChunks->findOne( array( "files_id" => $item->_id, "n" => $i ) );
                        $contents .=  $chunk["data"]->bin;
                    }
            
                    break;
            }
            
            $file->fwrite($contents);
            
            $reader = new \Ddeboer\DataImport\Reader\CsvReader($file, ",");
            $reader->setHeaderRowNumber(0);
            
            $this->app->set('item', $item);
            $this->app->set('count', count($reader));
            
            $skipped = 0;
            $inserted = 0;
            $updated = 0;
            $failed = 0;
            $errors = array();                        
            foreach ($reader as $row)
            {
                set_time_limit(0);
                
                if (empty($row['Original'])) {
                    $skipped++;
                	continue;
                }
                
                if (strpos( $row['Original'], '/' ) === 0 )
                {
                    $row['Original'] = substr($row['Original'], 1);
                }
                
                if (empty($row['Original'])) 
                {
                    $skipped++;
                    continue;
                }
                
                $redirect = \Redirect\Admin\Models\Routes::findOne(array(
                    'url.alias' => $row['Original']
                ));
                
                if (empty($redirect->id))
                {
                    // insert
                    $redirect = new \Redirect\Admin\Models\Routes;
                    $redirect->{'url.alias'} = $row['Original']; 
                    $redirect->{'url.redirect'} = $row['Target'];
                    
                    try 
                    {
                        $redirect->save();
                        $inserted++;
                    }
                    catch(\Exception $e)
                    {
                        $failed++;
                        $errors[] = $e->getMessage();
                    }
                }
                else
                {
                    // update
                    $redirect->{'url.alias'} = $row['Original'];
                    $redirect->{'url.redirect'} = $row['Target'];
                    
                    try
                    {
                        $redirect->save();
                        $updated++;
                    }
                    catch(\Exception $e)
                    {
                        $failed++;
                        $errors[] = $e->getMessage();
                    }                   
                }
            }
            
            $this->app->set('skipped', $skipped);
            $this->app->set('inserted', $inserted);
            $this->app->set('updated', $updated);
            $this->app->set('failed', $failed);
            $this->app->set('errors', $errors);
            $this->app->set('message', $message);
            
            echo $this->theme->render('Redirect/Admin/Views::importer/routes_results.php');
            
        } 
        catch ( \Exception $e ) 
        {
            \Dsc\System::addMessage( $e->getMessage(), 'error');
            $this->app->reroute('/admin/redirect/import');
            return;
        }
    }
}