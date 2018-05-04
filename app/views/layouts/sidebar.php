<ul class="nav nav-pills flex-column">
    <li class="nav-item">
        <a class="nav-link" href="/gallery">Gallery</a>
    </li>
	<?php
	if (isset($_SESSION['authorization']) && !empty($_SESSION['authorization'])) {
		?>
        <li class="nav-item">
            <a class="nav-link" href="/gallery/montage">Create new photo</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/gallery/upload">My uploads</a>
        </li>
		<?php
	} ?>
</ul>
<?php
//var_dump($ViewData);

if (isset($ViewData) && isset($ViewData['thumbnails'])) { ?>
    <hr class="gradient-line mb-1">
    <div class="row pl-2">
        <div class="col-12 text-center mb-1">
            <span class="text-info">Thumbnails</span>
        </div>
        <div id="sidebar-thumbnails" class="row m-0">
			<?php foreach ($ViewData['thumbnails'] as $img) { ?>
                <div class="col-6 p-0 m-0 vertical-center">
                    <a href="/gallery/image/<?= $img['id']; ?>" class="d-block position-relative">
                        <img src="<?= $img['src']; ?>" class="img-fluid">
                        <div class="overlay">
                            <button type="button" class="btn btn-danger rounded-circle btn-del-img-sidebar shadow-none btn-sm">
                                <i class="fa fa-trash fa-sm text-light"></i>
                            </button>
                            <i class="fa fa-comments fa-lg text-light"></i>
                        </div>
                    </a>
                </div>
			<?php } ?>
        </div>
    </div>
<?php } ?>
<script src="/public/scripts/deleteImage.js"></script>
