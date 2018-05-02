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
	}
	?>

</ul>
