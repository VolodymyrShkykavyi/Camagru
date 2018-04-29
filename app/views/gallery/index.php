<div class="row p-4">
    <div class="col-md-6">
        <a class="btn btn-primary" href="/gallery/montage">Montage photo</a>
    </div>
    <div class="col-md-6 m-auto">
        <a class="btn btn-primary" href="/gallery/upload">Upload photos</a>
    </div>
</div>

<?php
//var_dump($ViewData['images'][0]);
if (isset($ViewData['images'])) {
	foreach ($ViewData['images'] as $img) {
		?>
        <div class="row pb-3">
            <div class="col-sm-12 col-md-8 m-auto img-thumbnail p-1">
                <a href="/gallery/image/<?= $img['id']; ?>" class="d-block position-relative">
                    <div class="">
                        <img src="<?= $img['src']; ?>" class=" img-fluid w-100"/>
                    </div>
                    <div class="overlay rounded">
						<?php if (isset($_SESSION['authorization']) && !empty($_SESSION['authorization']) &&
							$_SESSION['authorization']['login'] == $img['login']): ?>
                            <button type="button" class="btn btn-danger rounded-circle btn-del-img shadow-none">
                                <i class="fa fa-trash fa-lg text-light"></i>
                            </button>
						<?php endif; ?>
                        <i class="fa fa-image fa-lg text-light"></i>
                        <span class="text-light">Detailed info</span>
                    </div>
                </a>
                <div class="img-thumbnail bg-light">
                    <div class="w-100">
                        <span class="small text-left">
                            <em>author: </em>
                            <a class="text-info decoration-none" href="/gallery/user/<?= $img['userId']; ?>">
                                <?= $img['login']; ?>
                            </a>
                        </span>
                        <span class="float-right position-relative">
                            <span class="mr-4 pr-2">
                                <?= ($img['likes_count']) ? $img['likes_count'] : 0; ?>
                            </span>
                            <i class="pl-1 like fa fa-heart text-danger <?php
							if (!isset($img['liked']) || !$img['liked']) {
								echo "fa-heart-o";
							} ?>"
                               onclick="changeLike(this, <?= $img['id']; ?>);"></i></span>
                    </div>
                    <hr class="gradient-line">

                    <div class="container">
						<?php foreach ($img['comments'] as $key => $comment) { ?>
                            <div class="row">
                                <div class="col-2 text-success">
									<?= $comment['login']; ?>
                                </div>
                                <div class="col-10 pb-2">
									<span>
                                        <?= $comment['text']; ?>
                                    </span>
                                </div>
                            </div>
                            <hr class="gradient-line">
						<?php } ?>
                    </div>
					<?php if (isset($_SESSION['authorization']) && !empty($_SESSION['authorization'])): ?>
                        <form class="form_comment" method="post">
                            <div class="form-row mt-2">
                                <div class="col-11">
                                    <textarea class="form-control shadow-none" rows="2"
                                              id="comment" name="comment"
                                              placeholder="Write your comment here..."></textarea>
                                </div>
                                <input type="hidden" name="imageId" value="<?= $img['id']; ?>">
                                <div class="col-1 vertical-center">
                                    <button type="button" name="btn_submit"
                                            class="btn btn-primary rounded-circle pl-2 shadow-none">
                                        <i class="fa fa-send"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
					<?php endif; ?>
                </div>
            </div>
        </div>

		<?php
	}
}
?>
<script src="/public/scripts/likes.js"></script>
<script src="/public/scripts/comment.js"></script>
<script src="/public/scripts/deleteImage.js"></script>