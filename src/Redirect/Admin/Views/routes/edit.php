<form id="detail-form" action="./admin/redirect/route/update/<?php echo $item->get( $model->getItemKey() ); ?>" class="form" method="post">
    <div class="row">
        <div class="col-md-12">
            <div class="form-actions clearfix">

                <div class="pull-right">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <input id="primarySubmit" type="hidden" value="save_edit" name="submitType" />
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a onclick="document.getElementById('primarySubmit').value='save_new'; document.getElementById('detail-form').submit();" href="javascript:void(0);">Save & Create Another</a>
                            </li>
                            <li>
                                <a onclick="document.getElementById('primarySubmit').value='save_close'; document.getElementById('detail-form').submit();" href="javascript:void(0);">Save & Close</a>
                            </li>
                        </ul>
                    </div>                          
                    &nbsp;
                    <a class="btn btn-default" href="./admin/redirect/routes">Cancel</a>
                </div>

            </div>
            <!-- /.form-actions -->        
            
            <hr />    
            
            <div class="form-group clearfix">
	            <label class="col-md-3">Title</label>
				<div class="col-md-7">
	                 <input type="text" name="metadata[title]" placeholder="Title" value="<?php echo $flash->old('metadata.title'); ?>" class="form-control" />
	           </div>
            </div>
            <!-- /.form-group -->

            <div class="form-group clearfix">
	            <label class="col-md-3">Original URL</label>
	            <div class="col-md-7">
					<input type="text" name="url[original]" placeholder="Original URL" value="<?php echo $flash->old('url.original'); ?>" class="form-control" />
				</div>
            </div>
            <!-- /.form-group -->

            <div class="form-group clearfix">
	            <label class="col-md-3">New Redirection</label>
	            <div class="col-md-7">
					<input type="text" name="url[redirect]" placeholder="New Redirection" value="<?php echo $flash->old('url.redirect'); ?>" class="form-control" />
				</div>
            </div>
            <!-- /.form-group -->
        </div>
        
    </div>
</form>