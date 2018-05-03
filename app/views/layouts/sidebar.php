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
	}?>
    </ul>
    <?php
	//var_dump($ViewData);

	if (isset($ViewData) && isset($ViewData['thumbnails'])) { ?>
        <hr class="gradient-line mb-1">
        <div class="row pl-2">
            <div class="col-12 text-center mb-1">
                <span class="text-info">Thumbnails</span>
            </div>
			<?php foreach ($ViewData['thumbnails'] as $img) { ?>
                <div class="col-6 p-0 m-0 vertical-center">
                    <img src="<?= $img['src']; ?>" class="img-fluid">
                </div>
			<?php } ?>
        </div>
	<?php } ?>

