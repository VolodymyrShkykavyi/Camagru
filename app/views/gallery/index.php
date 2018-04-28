<div class="row p-4">
    <div class="col-md-6">
        <a class="btn btn-primary" href="/gallery/montage">Montage photo</a>
    </div>
    <div class="col-md-6 m-auto">
        <a class="btn btn-primary" href="/gallery/upload">Upload photos</a>
    </div>
</div>

<?php
if (isset($ViewData['images'])) {
	foreach ($ViewData['images'] as $img) {
		?>
        <div class="row pb-3">
            <div class="col-sm-12 col-md-8 m-auto img-thumbnail p-1">
                <a href="/gallery/image?id=<?= $img['id']; ?>" class="d-block position-relative">
                    <div class="">
                        <img src="<?= $img['src']; ?>" class=" img-fluid w-100"/>
                    </div>
                    <div class="overlay rounded">
                        <i class="fa fa-image fa-lg text-light"></i>
                        <span class="text-light">Detailed info</span>
                    </div>
                </a>
                <div class="img-thumbnail bg-light">
                    <div class="w-100">
                        <span class="small text-left">author: ass</span>
                        <span class="float-right"><i class="fa fa-heart text-danger"></i> 12 <i
                                    class="fa fa-heart-o text-danger"></i> </span>
                    </div>
                    <div class="container">
                        comments<br>comm
                    </div>
                    <div class="form-row">
                        <div class="col-11">
                            <textarea class="form-control shadow-none" rows="2" id="comment"></textarea>
                        </div>
                        <div class="col-1 vertical-center">
                            <button class="btn btn-primary rounded-circle pl-2 shadow-none"><i class="fa fa-send"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

		<?php
	}
}
?>


