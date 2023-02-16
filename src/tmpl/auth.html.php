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
		</ul>
	</nav>
	<main>
		<h1><?= isset($title) ? $title : '' ?></h1>
		<div class="form-container">
			<form id="authForm">
				<div class="form-row hidden">
					<span class="errorInfo"></span>
				</div>
				<div class="form-row">
					<input type="text" name="login" required placeholder="login: admin">
				</div>
				<div class="form-row">
					<input type="password" name="password" required placeholder="password: admin">
				</div>
				<div class="form-row">
					<button>Вход</button>
				</div>
			</form>
		</div>
	</main>
</div>
<script>
	document.addEventListener('DOMContentLoaded', function (){
		document.getElementById('authForm').addEventListener('submit', function (event){
			event.preventDefault()
			const login = this.querySelector('input[name="login"]');
			const password = this.querySelector('input[name="password"]');
			const errorInfo = this.querySelector('span.errorInfo');
			errorInfo.parentNode.classList.add('hidden');
			document.body.classList.add('fetch');
			fetch('/login', {
				method: 'POST',
				body: JSON.stringify({login: login.value, password: password.value})
			})
			.then(response => {
				if (response.status >= 200 && response.status < 300)
				{
					//Авторизация прошла успешно
					document.location.replace('/admin');
				}
				else
				{
					response.json().then(data => {
						if (data.message)
						{
							errorInfo.innerText = data.message;
							errorInfo.parentNode.classList.remove('hidden');
						}
					});
				}
			})
			.catch(err => {
				console.log(err);
				errorInfo.innerText = 'Ошибка запроса';
				errorInfo.parentNode.classList.remove('hidden');
			})
			.finally(()=>{document.body.classList.remove('fetch')});

		})
	})
</script>
</body>
</html>
