<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Upload a New File</h3>
    </div>
    <div class="panel-body">
        <form id="detail-form" class="form" method="post" action="./admin/redirect/import/handleUpload" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="file" name="import_file" class="form-control" />
                        <span class="input-group-btn">
                            <input type="submit" name="import_submit" class="btn btn-primary" value="Upload" />
                        </span>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>