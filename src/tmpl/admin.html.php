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
				<a href="/logout">Выход</a>
			</li>
		</ul>
	</nav>
	<main>
		<h1><?= isset($title) ? $title : '' ?></h1>
		<button data-add-root="1" title="добавить корневой раздел"><i class="icon add"></i></button>
		<?php
		include 'treePrint.php';
		if (isset($list))
		{
			treePrint($list, true);
		}
		else
		{
			treePrint([], true);
		}
		?>
	</main>
</div>
<script src="/assets/js/tree-view.js"></script>
</body>
</html>
