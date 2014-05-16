<div class="no-padding">

    <div class="row">
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
            <ul class="list-filters list-unstyled list-inline">
                <li></li>
            </ul>
        </div>
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <div class="form-group">
                <div class="input-group">
                    <input class="form-control" type="text" name="filter[keyword]" placeholder="Search..." maxlength="200" value="<?php echo $state->get('filter.keyword'); ?>">
                    <span class="input-group-btn"> <input class="btn btn-primary" type="submit" onclick="this.form.submit();" value="Search" />
                        <button class="btn btn-danger" type="button" onclick="Dsc.resetFormFilters(this.form);">Reset</button>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <ul class="list-filters list-unstyled list-inline">
                <li>
                    <select name="list[order]" class="form-control" onchange="this.form.submit();">
                        <option value="metadata.created.time" <?php if ($state->get('list.order') == 'metadata.created.time') { echo "selected='selected'"; } ?>>Created</option>
                        <option value="last_hit.time" <?php if ($state->get('list.order') == 'last_hit.time') { echo "selected='selected'"; } ?>>Last Hit</option>
                        <option value="hits" <?php if ($state->get('list.order') == 'hits') { echo "selected='selected'"; } ?>>Hits</option>
                    </select>
                </li>
                <li>
                    <select name="list[direction]" class="form-control" onchange="this.form.submit();">
                        <option value="1" <?php if ($state->get('list.direction') == '1') { echo "selected='selected'"; } ?>>ASC</option>
                        <option value="-1" <?php if ($state->get('list.direction') == '-1') { echo "selected='selected'"; } ?>>DESC</option>
                    </select>
                </li>
            </ul>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="text-align-right">
                <ul class="list-filters list-unstyled list-inline">
                    <li>
                        <?php if (!empty($paginated->items)) { ?>
                        <?php echo $paginated->getLimitBox( $state->get('list.limit') ); ?>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="widget-body-toolbar">

        <div class="row">
            <div class="col-xs-12 col-sm-5 col-md-3 col-lg-3">
                <span class="pagination">
                    <div class="input-group">
                        <select id="bulk-actions" name="bulk_action" class="form-control">
                            <option value="null">-Bulk Actions-</option>
                            <option value="delete" data-action="./admin/redirect/routes/delete">Delete</option>
                        </select>
                        <span class="input-group-btn">
                            <button class="btn btn-default bulk-actions" type="button" data-target="bulk-actions">Apply</button>
                        </span>
                    </div>
                </span>
            </div>
            <div class="col-xs-12 col-sm-7 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
                <div class="row text-align-right">
                    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                        <?php if (!empty($paginated->total_pages) && $paginated->total_pages > 1) { ?>
                        <?php echo $paginated->serve(); ?>
                        <?php } ?>
                    </div>
                    <?php if (!empty($paginated->items)) { ?>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <span class="pagination">
                            <?php echo $paginated->getLimitBox( $state->get('list.limit') ); ?>
                        </span>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>

    </div>
    <!-- /.widget-body-toolbar -->


    <div class="table-responsive datatable dt-wrapper dataTables_wrapper">

        <table class="table table-striped table-bordered table-hover table-highlight table-checkable">
            <thead>
                <tr>
                    <th class="checkbox-column">
                        <input type="checkbox" class="icheck-input">
                    </th>
                    <th class="col-md-7">Title</th>
                    <th data-sortable="metadata.created.time">Created</th>
                    <th data-sortable="last_hit.time">Last Hit</th>
                    <th data-sortable="hits">Hits</th>
                    <th class="col-md-1"></th>
                </tr>
            </thead>
            <tbody>    
            	
                    <?php if (!empty($paginated->items)) { ?>
                    <?php foreach($paginated->items as $item) { ?>
            	    <tr>
                        <td class="checkbox-column">
                            <input type="checkbox" class="icheck-input" name="ids[]" value="<?php echo $item->_id; ?>">
                        </td>
    
                        <td class="">
                            <div>
                                <a class="" href="./admin/redirect/route/edit/<?php echo $item->_id; ?>">
                                    <b>Alias/404-Error URL:</b> /<?php echo $item->{'url.alias'}; ?>
                                </a>
                                &nbsp;
                                <a class="btn btn-default btn-sm" target="_blank" href="./<?php echo $item->{'url.alias'}; ?>"> Visit </a>
                            </div>
    
                            <div>
                                <a class="" href="./admin/redirect/route/edit/<?php echo $item->_id; ?>">
                                    <b>Redirect URL:</b> /<?php echo $item->{'url.redirect'}; ?>
                                </a>
                                &nbsp;
                                <a class="btn btn-default btn-sm" target="_blank" href="./<?php echo $item->{'url.redirect'}; ?>"> Visit </a>
                            </div>
    
                        </td>
    
                        <td class="">
                	            <?php echo $item->{'metadata.creator.name'}; ?><br />
                	            <?php echo $item->{'metadata.created.time'} ? date( 'Y-m-d h:ia', $item->{'metadata.created.time'} ) : null; ?>
                	    </td>
    
                        <td class="">
                	            <?php echo $item->{'metadata.last_modified.time'} ? date( 'Y-m-d h:ia', $item->{'metadata.last_modified.time'} ) : null; ?>
                	    </td>
    
                        <td>
                	               <?php echo (int) $item->hits; ?>
                	    </td>
    
                        <td class="text-center">
                            <a class="btn btn-xs btn-secondary" href="./admin/redirect/route/edit/<?php echo $item->_id; ?>">
                                <i class="fa fa-pencil"></i>
                            </a>
                            &nbsp;
                            <a class="btn btn-xs btn-danger" data-bootbox="confirm" href="./admin/redirect/route/delete/<?php echo $item->_id; ?>">
                                <i class="fa fa-times"></i>
                            </a>
                        </td>
                    </tr>
            	    <?php } ?>
            	    
            	    <?php } else { ?>
            	    <tr>
                        <td colspan="100">
                            <div class="">No items found.</div>
                        </td>
                    </tr>
            	    <?php } ?>
            	
            	    </tbody>
        </table>

    </div>

    <div class="dt-row dt-bottom-row">
        <div class="row">
            <div class="col-sm-10">
		    	<?php if (!empty($paginated->total_pages) && $paginated->total_pages > 1) { ?>
		        	<?php echo $paginated->serve(); ?>
		        <?php } ?>
	      	</div>
            <div class="col-sm-2">
                <div class="datatable-results-count pull-right">
                    <span class="pagination">
	                	<?php echo (!empty($paginated->total_pages)) ? $paginated->getResultsCounter() : null; ?>
	            	</span>
                </div>
            </div>
        </div>
    </div>
</div>
