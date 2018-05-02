<?php
if (isset($ViewData) && isset($ViewData['comments'])):?>
    <div class="container">
		<?php foreach ($ViewData['comments'] as $comment) { ?>
            <div class="row">
                <div class="col-2 text-success">
					<?= $comment['login']; ?>
                </div>
                <div class="col-10 pb-2">
                    <span><?= $comment['text']; ?></span>
                </div>
            </div>
            <hr class="gradient-line">
		<?php } ?>
    </div>
<?php endif; ?>
