<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
			content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="/assets/css/style.css">
	<title><?= isset($title) ? $title : '' ?></title>
</head>
<body>
<div class="container">
	<nav>
		<ul class="menu">
			<li class="menuItem">
				<a href="/">Главная</a>
			</li>
			<li class="menuItem">
				<a href="/admin">Админка</a>
			</li>
		</ul>
	</nav>
	<main>
		<h1><?= isset($title) ? $title : '' ?></h1>

		<?php
		function print_tree($data)
		{
			echo '<ul class="tree">';
			foreach ($data as $node)
			{
				?>
				<li class="hide-inner-node" data-toggle="<?= $node['id'] ?>">
					<div class="tree-node">
						<div class="tree-node-control">
							<?php if (!empty($node['child'])): ?>
							<button data-toggler="<?= $node['id'] ?>"><i class="icon"></i></button>
							<?php endif; ?>
						</div>
						<div class="tree-node-title">
							<div class="node-title">
								<div class="node-title__title"><?= $node['title'] ?></div>
								<div class="node-title__control">
<!--									<button><i class="icon delete"></i></button>-->
<!--									<button><i class="icon edit"></i></button>-->
<!--									<button><i class="icon add"></i></button>-->
								</div>
							</div>
							<div class="node-desc"><?= isset ($node['desc']) ? $node['desc'] : '' ?></div>
						</div>
					</div>
					<?php if (!empty($node['child'])) print_tree($node['child']); ?>
				</li>
				<?php
			}
			echo '</ul>';
		}
		if (isset($list))
		{
			print_tree($list, true);
		}

		?>


	</main>
</div>
<script>
	document.addEventListener('DOMContentLoaded', function (){
		//console.log(
			document.querySelectorAll('ul.tree button[data-toggler]').forEach(el => {
				const marker = el.dataset.toggler;
				const toggled = document.querySelector('li[data-toggle="' + marker + '"]');
				el.addEventListener('click', () => {
					toggled.classList.toggle('hide-inner-node');
				})


			})
		//);
	})
</script>
</body>
</html>
