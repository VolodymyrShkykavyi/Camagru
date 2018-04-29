<?php
if (isset($ViewData) && isset($ViewData['errors'])) {
	echo $ViewData['errors'];
}
?>

<div class="row mt-3">
    <div class="m-auto">
        <form action="/gallery/upload" method="post" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header">Upload new photo</div>
                <div class="card-body">
                    <p class="card-text text-danger d-none" id="error_msg">
                        Select image to upload
                    </p>
                    <div class="input-group">
                        <input type="text" id="filename" class="form-control" disabled="disabled">
                        <div class="btn btn-light input-group-append" id="btn_browse">
                            <span><i class="fa fa-folder-open mr-1"></i>Browse</span>
                            <input type="file" name="image" accept="image/png, image/gif, image/jpeg, image/jpg"
                                   class="d-none">
                        </div>
                        <button type="submit" id="btn_upload" class="btn btn-labeled btn-primary">
                            <span class="btn-label"><i class="fa fa-cloud-upload mr-1"></i>Upload</span>
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
<div class="row text-center text-dark mt-4">
    <hr>
    <h2 class="text-muted">My uploads</h2>
    <hr>
</div>
<div class="row">

	<?php
	if (isset($ViewData) && isset($ViewData['userImg'])) {
		foreach ($ViewData['userImg'] as $img) {
			?>
            <div class="col-lg-4 col-md-4 col-xs-6 mt-2 mb-2 ">
                <a href="/gallery/image/<?=$img['id']; ?>" class="d-block position-relative">
                    <div class="img-thumbnail">
                        <img src="<?= $img['src']; ?>" class=" img-fluid w-100"/>
                    </div>
                    <div class="overlay rounded">
                        <button type="button" class="btn btn-danger rounded-circle btn-del-img shadow-none">
                            <i class="fa fa-trash fa-lg text-light"></i>
                        </button>
                        <i class="fa fa-comments fa-lg text-light"></i>
                    </div>
                </a>
            </div>
			<?php
		}
	}
	?>
</div>

<script src="/public/scripts/upload_img.js"></script>
<script src="/public/scripts/deleteImage.js"></script>