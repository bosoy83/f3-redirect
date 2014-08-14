<div class="panel panel-default">
    <div class="panel-heading">
        <div class="clearfix">
            <h3 class="panel-title pull-left">Handle an Existing Upload</h3>
            <a class="pull-right" href="./admin/assets?filter[type]=redirect.importer">Manage Uploaded Files</a>
        </div>
    </div>
    <div class="panel-body">
        <?php $paginated = (new \Dsc\Mongo\Collections\Assets)->setState('filter.type', 'redirect.importer')->paginate(); ?>
        <?php foreach ($paginated->items as $asset) { ?>
            <div class="list-group-item">
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $asset->title; ?>
                        <p>Created: <?php echo $asset->{'metadata.created.local'}; ?></p>
                    </div>
                    <div class="col-md-2">
                        <a href="./admin/redirect/import/preview/<?php echo $asset->id; ?>" class="btn btn-warning">Preview Import</a>
                    </div>                    
                </div>
            </div>
        <?php } ?>
        
        <?php if (empty($paginated->items)) { ?>
            <div>No items found.</div>
        <?php } ?>
    </div>
</div>