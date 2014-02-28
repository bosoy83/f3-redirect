<div class="row">
    <div class="col-md-9">
        <form id="routes" class="searchForm" action="./admin/redirect/routes" method="post">
    		<?php echo $this->renderLayout('Redirect/Admin/Views::routes/list_datatable.php'); ?>    
        </form>
    </div>
    <div class="col-md-3">
	    <?php echo \Dsc\Request::internal( "\Redirect\Admin\Controllers\Route->quickadd" ); ?>	
    </div>
</div>