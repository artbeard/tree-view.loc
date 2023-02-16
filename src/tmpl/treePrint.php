<?php

/**
 * Функция отрисовки дерева
 * @param $data
 * @param false $admin
 */
function treePrint($data, $admin = false)
{
	echo '<ul class="tree">';
	foreach ($data as $node)
	{
		?>
		<li class="hide-inner-node"
		    data-toggle="<?= $node['id'] ?>"
		    data-title="<?= $node['title'] ?>"
		    data-desc="<?= $node['desc'] ?>">
			<div class="tree-node">
				<div class="tree-node-control">
					<?php if ($admin): ?>
					<button data-move="<?= $node['id'] ?>"><i class="icon move"></i></button>
					<?php endif; ?>
				</div>
				<div class="tree-node-title">
					<div class="node-title">
						<div class="node-title__title"><?= $node['title'] ?></div>
						<div class="node-title__control">
							<?php if (!empty($node['child'])): ?>
								<button class="folder" data-toggler="<?= $node['id'] ?>"><i class="icon"></i></button>
							<?php endif; ?>
							<?php if ($admin): ?>
							<button data-delete="<?= $node['id'] ?>"><i class="icon delete"></i></button>
							<button data-edit="<?= $node['id'] ?>"><i class="icon edit"></i></button>
							<button data-add-to="<?= $node['id'] ?>"><i class="icon add"></i></button>
							<?php endif; ?>
						</div>
					</div>
					<div class="node-desc"><?= $node['desc'] ?></div>
				</div>
			</div>
			<?php if (!empty($node['child'])) treePrint($node['child'], $admin); ?>
		</li>
		<?php
	}
	echo '</ul>';
}
