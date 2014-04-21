<div class="well">

<form id="settings-form" role="form" method="post" class="form-horizontal clearfix">

    <div class="clearfix">
        <button type="submit" class="btn btn-primary pull-right">Save Changes</button>
    </div>

    <hr />

    <div class="row">
        <div class="col-md-3 col-sm-4">
            <ul class="nav nav-pills nav-stacked">
                <li class="active">
                    <a href="#tab-general" data-toggle="tab"> General Settings </a>
                </li>
            </ul>
        </div>

        <div class="col-md-9 col-sm-8">

            <div class="tab-content stacked-content">

                <div class="tab-pane fade in active" id="tab-general">
                    <h4>General Settings</h4>
                    
                    <hr />

                    <div class="form-group">
                        <label>Default Error route</label>
                        <input type="text" name="general[default_error_404]" placeholder="A route, starting with /" value="<?php echo $flash->old('general.default_error_404') ?>" class="form-control" />
                        <p class="help-block">
                        Start your route with /<br/>For example:<br/><i>/ (which would mean your homepage)</i><br/><i>/pages/404</i><br/><i>/custom/404</i> 
                    </div>
                </div>
            </div>

        </div>
    </div>

</form>

</div>