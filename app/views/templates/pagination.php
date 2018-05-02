<?php
if (isset($ViewData) && isset($ViewData['pagination'])): ?>
    <nav class="col-12">
        <ul class="pagination justify-content-center">
			<?php foreach ($ViewData['pagination'] as $el) { ?>
                <li class="page-item
                <?= (!$el['able'] && !$el['active']) ? 'disabled' : ''; ?>
                <?= (!$el['active']) ? '' : 'active'; ?>
                ">
					<?php if ($el['able']): ?>
                    <a href="<?= $el['href']; ?>" class="page-link">
						<?php endif; ?>
                        <span class="<?= ($el['able']) ? '' : 'page-link'; ?>"><?= (empty($el) ? '...' : $el['value']); ?></span>
						<?php if ($el['able']): ?>
                    </a>
				<?php endif; ?>
                </li>
			<?php } ?>
        </ul>
    </nav>
<?php endif; ?>