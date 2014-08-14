<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-table fa-fw "></i> Import
            <span> > Preview </span>
        </h1>
    </div>
    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
        <ul id="sparks" class="list-inline pull-right">
            <li>
                <a class="btn btn-default" href="./admin/redirect/import">Close</a>
            </li>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <h2>File: <?php echo $item->title; ?>
            <small class="help-block">Created: <?php echo $item->{'metadata.created.local'}; ?></small>
        </h2>        
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <h3>There are <b><?php echo $count; ?></b> rows in the following format: </h3>
        <?php echo $this->app->get('preview'); ?>
    </div>
    <div class="col-md-4">
        <h3>Actions:</h3>
        <div class="list-group">
            <div class="list-group-item">
                <a class="btn btn-primary" href="./admin/redirect/import/routes/<?php echo $item->id;?>">Import Redirects</a>
                <p class="help-block"><small>Performs inserts and updates</small></p>
            </div>
        </div>
    </div>
</div>