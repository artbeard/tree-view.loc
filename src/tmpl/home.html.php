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
			<li class="menuItem">
				<a href="/logout">Выход</a>
			</li>
		</ul>
	</nav>
	<main>
		<h1><?= isset($title) ? $title : '' ?></h1>

		<pre>
		<?php
		function print_tree($data)
		{
			echo '<ul>';
			foreach ($data as $node)
			{
				echo '<li>';
				echo $node['title'];
				if (!empty($node['child']))
				{
					print_tree($node['child']);
				}
				echo '</li>';
			}
			echo '</ul>';
		}
		//$list
		if (isset($list))
		{
			//echo print_r($list, true);
			//print_r('133');
			print_tree($list);
		}

		?>
		</pre>

	</main>
</div>
<script>
	document.addEventListener('DOMContentLoaded', function (){
	})
</script>
</body>
</html>
