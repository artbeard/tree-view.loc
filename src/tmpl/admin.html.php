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
		<?php
		include 'treePrint.php';
		if (isset($list))
		{
			treePrint($list, true);
		}
		?>
	</main>
	<div class="modal hidden">
		<div class="form-container">
			<form id="addNodeForm">
				<div class="form-row hidden">
					<span class="errorInfo"></span>
				</div>
				<div class="form-row">
					<input type="text" name="title" required placeholder="Загловок">
				</div>
				<div class="form-row">
					<input type="text" name="desc" required placeholder="Описание">
				</div>
				<div class="form-row">
					<button type="button" class="onOk">Добавить</button>
					<button type="button" class="onCancel">Отмена</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script src="/assets/js/tree-view.js?<?= time() ?>"></script>
</body>
</html>
