<div class="row pt-3 pb-2">
    <div class="col-12 text-center">
        Welcome to montage page.

    </div>
</div>
<div class="row mb-4">
    <div class="col-md-6 col-lg-6 col-sm-12">
        <div>
            <div id="image-main-upload" class="h-100 w-100 small">
                <form action="/gallery/upload" method="post" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header  text-center">Select photo from disk. Recommend proportions
                            <span class="text-warning">4x3</span></div>
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
                                <button type="button" id="btn_load" class="btn btn-labeled btn-primary shadow-none">
                                    <span class="btn-label"><i class="fa fa-image mr-1"></i>Load</span>
                                </button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div id="image-preview" class="position-relative">
                <video id="video" class="webcam" autoplay muted hidden></video>
                <canvas id="image-main" class="bg-light w-100"></canvas>
                <canvas id="image-decoration" class="w-100"></canvas>
            </div>
            <button class="btn btn-danger w-100 shadow-none" id="btn_photo">Select one effect</button>
            <button type="button" id="btn_loader" class="btn btn-warning shadow-none w-100" style="display: none">
                <span class="fa preloader"></span>
                <span class="pl-1">Please wait</span>
            </button>
        </div>
    </div>
    <div class="col-md-6 col-lg-6 col-sm-12">
        <div class="w-100">
            <form id="decoration-settings">
                <div class="w-100 mb-2">
                    <span class="text-success">Decoration settings</span>
                    <button class="btn btn-danger shadow-none float-right btn-sm" type="reset" name="btn_reset">Reset
                    </button>
                </div>
                <div class="input-group">
                    <label class="input-group-prepend">Width: </label>
                    <input class="pl-1 custom-range form-control border-0 shadow-none" type="range" name="setWidth"
                           min="0" max="150" value="100">
                    <span class="input-group-append">100%</span>
                </div>
                <div class="input-group">
                    <span class="input-group-prepend">Height: </span>
                    <input class="pl-1 custom-range form-control border-0 shadow-none" type="range" name="setHeight"
                           min="0" max="150" value="100">
                    <span class="input-group-append">100%</span>
                </div>
                <div class="input-group">
                    <span class="input-group-prepend">Move horizontally: </span>
                    <input class="ml-1 small form-control p-0 shadow-none" type="number" name="setOX" value="0"
                           style="max-width: 50px" step="2">
                    <span class="input-group-append ml-1">px</span>
                </div>
                <div class="input-group">
                    <span class="input-group-prepend">Move vertically: </span>
                    <input class="ml-1 small form-control p-0 shadow-none" type="number" name="setOY" value="0"
                           style="max-width: 50px" step="2">
                    <span class="input-group-append ml-1">px</span>
                </div>
            </form>
        </div>
        <hr class="mb-1">
        <div class="pb-1">
            <span class="text-success">Decorations</span>
        </div>
        <form id="decoration">
            <div class="form-row">
				<?php if (isset($ViewData) && isset($ViewData['decorations'])) {
					foreach ($ViewData['decorations'] as $src) { ?>
                        <div class="mr-2 decoration-thumbnail">
                            <label onclick="drawDecoration(this);">
                                <input type="radio" name="btn_radio" hidden>
                                <img src="<?= $src; ?>" style="max-width: 200px; max-height: 100px;"
                                     class="img-thumbnail">
                            </label>
                        </div>
					<?php }
				} ?>
            </div>
        </form>
    </div>
</div>

<script src="/public/scripts/webcam.js"></script>
<script src="/public/scripts/upload_img.js"></script>