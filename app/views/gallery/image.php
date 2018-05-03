<div class="container mt-2 mb-5">
    <div class="row">
        <div class="img-thumbnail col-12">
            <img src="<?= $ViewData['image']['src']; ?>" class="img-fluid w-100">

            <div class="w-100">
                        <span class="small text-left">
                            <em>author: </em>
                            <a class="text-info decoration-none"
                               href="/gallery/user/<?= $ViewData['image']['userId']; ?>">
                                <?= $ViewData['image']['author']; ?>
                            </a>
                        </span>
                <span class="float-right position-relative pb-1">
                            <span class="mr-4 pr-2">
                                <?= ($ViewData['image']['likes_count']) ? $ViewData['image']['likes_count'] : 0; ?>
                            </span>
                            <i class="pl-1 like fa fa-heart text-danger <?php
							if (!isset($ViewData['image']['liked']) || !$ViewData['image']['liked']) {
								echo "fa-heart-o";
							} ?>"
                               onclick="changeLike(this, <?= $ViewData['image']['id']; ?>);"></i>
                        </span>
            </div>
            <div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item  pl-0">
                        <span class="">Uploaded:</span>
                        <span class=""><?= $ViewData['image']['date']; ?></span>
                    </li>
                </ul>
            </div>
            <div class="">
                <div class="card-header col-12 mb-3">Comments</div>
                <div class="card-body pt-1">
					<?php include_once('/app/views/templates/imageComments.php'); ?>
					<?php if (isset($_SESSION['authorization']) && !empty($_SESSION['authorization'])): ?>
                    <form class="form_comment w-100 mr-1 ml-3" method="post">
                        <div class="form-row mt-2">
                            <div class="col-11">
                                    <textarea class="form-control shadow-none" rows="2"
                                              id="comment" name="comment"
                                              placeholder="Write your comment here..."></textarea>
                            </div>
                            <input type="hidden" name="imageId" value="<?= $ViewData['image']['id']; ?>">
                            <div class="col-1 vertical-center">
                                <button type="button" name="btn_submit"
                                        class="btn btn-primary rounded-circle pl-2 shadow-none">
                                    <i class="fa fa-send"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
				<?php endif; ?>
            </div>
        </div>
    </div>
</div>


<script src="/public/scripts/likes.js"></script>
<script src="/public/scripts/comment.js"></script>