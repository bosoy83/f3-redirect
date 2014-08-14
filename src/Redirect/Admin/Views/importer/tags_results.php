<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-table fa-fw "></i> Import Tags
            <span> > Results </span>
        </h1>
    </div>
    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
        <ul id="sparks" class="list-inline pull-right">
            <li>
                <a class="btn btn-default" href="./admin/styleplate/import/preview/<?php echo $item->id; ?>">Return to Preview</a>
            </li>        
            <li>
                <a class="btn btn-default" href="./admin/styleplate/import">Return to List</a>
            </li>
        </ul>
    </div>
</div>

<p class="alert alert-danger">
    <b>Alert as of June 11, 2014</b> - No import is actually being performed
</p>

<div class="row">
    <div class="col-md-12">
        <h2>File: <?php echo $item->title; ?>
            <small class="help-block">Created: <?php echo $item->{'metadata.created.local'}; ?></small>
        </h2>        
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <h3>There were <b><?php echo $count; ?></b> rows. </h3>
        <h4><b><?php echo $skipped; ?></b> were skipped for not having a 'Main Image' value. </h4>
        
        <h4>These <b><?php echo $updated; ?></b> were updated: </h4>
        <?php echo $message; ?>
    </div>
    <div class="col-md-6">
        <h3>Errors:</h3>
        
        <div class="list-group">
            <div class="list-group-item list-group-item-warning">
                These items did not have assets
            </div>
            <?php foreach ($not_found as $error) { ?>
                <div class="list-group-item list-group-item-danger">
                    <?php echo \Dsc\Debug::dump( $error ); ?>
                </div>        
            <?php } ?>
        </div>
    </div>
</div>