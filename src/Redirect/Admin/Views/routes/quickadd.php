<div class="portlet">

    <div class="portlet-header">

        <h3>Add New Redirection</h3>

    </div>
    <!-- /.portlet-header -->

    <div class="portlet-content">
        <div id="quick-form-response-container"></div>

        <form id="quick-form" action="./admin/redirect/route/add"
            class="form dsc-ajax-form" method="post"
            data-message_container="quick-form-response-container"
            data-refresh_list="true" data-list_container="routes">

            <div class="form-group">
                <input type="text" name="metadata[title]" placeholder="Title"
                    class="form-control" />
            </div>
            <!-- /.form-group -->

            <div class="form-group">
                <input type="text" name="url[original]" placeholder="Original URL"
                    class="form-control" />
            </div>
            <!-- /.form-group -->

            <div class="form-group">
                <input type="text" name="url[redirect]" placeholder="New Redirection"
                    class="form-control" />
            </div>
            <!-- /.form-group -->
            <hr />

            <div class="form-actions">

                <div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>

            </div>
            <!-- /.form-group -->
        </form>

    </div>
    <!-- /.portlet-content -->

</div>
<!-- /.portlet -->