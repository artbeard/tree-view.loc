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
		<div id="treeWrap"></div>



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
<script>

	function ModalBox()
	{
		this.mbox = document.querySelector('.modal');

		this.onOkCallback = function (){}

		this.show = function (onCreate)
		{
			this.onOkCallback = onCreate;
			this.mbox.classList.remove('hidden');
			this.mbox.querySelector('form').reset();
			this.mbox.querySelector('input[name="title"]').focus();
		}

		this.hide = function ()
		{
			this.mbox.classList.add('hidden');
		}

		this.collectData = function (){
			return {
				title: this.mbox.querySelector('input[name="title"]').value,
				desc: this.mbox.querySelector('input[name="desc"]').value,
			}
		}

		this.mbox.querySelector('button.onCancel').addEventListener('click', ()=>{
			this.hide();
		})
		this.mbox.querySelector('button.onOk').addEventListener('click', ()=>{
			this.onOkCallback(this.collectData())
		})

	}


	function onCreateNewNode()
	{

	}

	function createTree(nodeList)
	{
		const ul = document.createElement('ul');
		ul.classList.add('tree');
		nodeList.forEach(el_node => {
			ul.append(createTreeNode(el_node));
		})

		return ul;
	}

	function createTreeNode(node)
	{
		const template = `<div class="tree-node">
			<div class="tree-node-control">
			</div>
			<div class="tree-node-title">
				<div class="node-title">
					<div class="node-title__title">${node.title}</div>
					<div class="node-title__control">
						<button data-delete="${node.id}"><i class="icon delete"></i></button>
						<button data-edit="${node.id}"><i class="icon edit"></i></button>
						<button data-add-to="${node.id}"><i class="icon add"></i></button>
					</div>
				</div>
				<div class="node-desc">${node.desc}</div>
			</div>
		</div>`;

		const li = document.createElement('li');
		li.innerHTML = template;

		li.dataset.toggle = node.id;
		li.classList.add('hide-inner-node');

		if (node.child && node.child.length)
		{
			const button = document.createElement('button');
			button.innerHTML = '<i class="icon"></i>';
			button.dataset.toggler = node.id;
			li.querySelector('.tree-node-control').append(button);

			let cildNode = createTree(node.child);
			li.append(cildNode);
		}
		return li;
	}

	document.addEventListener('DOMContentLoaded', function (){

		const modalBox = new ModalBox();

		fetch('/api/list')
		.then(resp => resp.json())
		.then(data => {
			const tree = createTree(data.treeList);
			tree.addEventListener('click', function (event){
				let button;
				if (event.target.nodeName === 'BUTTON')
				{
					button = event.target;
				}
				else if (event.target.nodeName === 'I' && event.target.parentNode.nodeName === 'BUTTON')
				{
					button = event.target.parentNode;
				}
				if (button)
				{
					//Обработчик для переключателя ветки
					if (button.dataset.toggler)
					{
						const mark = button.dataset.toggler;
						const toggleElement = document.querySelector(`li[data-toggle="${mark}"]`);
						toggleElement.classList.toggle('hide-inner-node')
					}
					else if (button.dataset.delete)
					{
						let countSisterly = button.closest('ul').childNodes.length;
						if (countSisterly == 1)
						{
							button.closest('ul').remove();
						}
						else
						{
							button.closest('li').remove();
						}
					}
					else if (button.dataset.addTo)
					{
						modalBox.show((nodeFields)=>{
							console.log(nodeFields);
							nodeFields.id = (new Date()).getMilliseconds();
							let list = button.closest('li').querySelector('ul');
							if (list)
							{
								//Добавление в этот список
								list.append(createTreeNode(nodeFields));
								button.closest('li').classList.remove('hide-inner-node');
							}
							else
							{
								//Создание списка
								button.closest('li').append(
									createTree([nodeFields])
								)

								const btn = document.createElement('button');
								btn.innerHTML = '<i class="icon"></i>';
								btn.dataset.toggler = button.closest('li').dataset.toggle;
								button.closest('li').querySelector('.tree-node-control').append(btn);
								button.closest('li').classList.remove('hide-inner-node');
							}
							modalBox.hide();
						});

					}
					else
					{
						console.log(button.dataset)
					}

				}
				//console.log(button);
			});

			document.getElementById('treeWrap').append(tree);

			//console.log(tree);
		})
		.catch(err => console.log(err));

		// document.querySelectorAll('ul.tree button[data-toggler]').forEach(el => {
		// 	const marker = el.dataset.toggler;
		// 	const toggled = document.querySelector('li[data-toggle="' + marker + '"]');
		// 	el.addEventListener('click', () => {
		// 		toggled.classList.toggle('hide-inner-node');
		// 	})
		// })

	})
</script>
</body>
</html>
