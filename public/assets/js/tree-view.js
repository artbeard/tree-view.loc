function treeView()
{
	//Типа анимация ajax запрсов
	function fetch_anim(status = false)
	{
		if (status)
		{
			document.body.classList.add('fetch')
		}
		else
		{
			document.body.classList.remove('fetch')
		}
	}

	function ModalBox()
	{
		this.mbox = document.createElement('div');
		this.mbox.classList.add('modal', 'hidden');
		this.mbox.innerHTML = `<div class="form-container">
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
		</div>`;
		document.body.append(this.mbox);

		this.onOkCallback = function (){}

		this.show = function (onCreate, defaultValue = null)
		{
			this.onOkCallback = onCreate;
			this.mbox.classList.remove('hidden');
			this.mbox.querySelector('form').reset();
			if (defaultValue)
			{
				this.setDefaultData(defaultValue);
			}
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

		this.setDefaultData = function (data){
			this.mbox.querySelector('input[name="title"]').value = data.title;
			this.mbox.querySelector('input[name="desc"]').value = data.desc;
		}

		this.mbox.querySelector('button.onCancel').addEventListener('click', ()=>{
			this.hide();
		})
		this.mbox.querySelector('button.onOk').addEventListener('click', ()=>{
			this.onOkCallback(this.collectData())
		})
	}

	const modalBox = new ModalBox();

	/**
	 * Создает дерево
	 * @param nodeList
	 * @return {HTMLUListElement}
	 */
	function createTree(nodeList)
	{
		const ul = document.createElement('ul');
		ul.classList.add('tree');
		nodeList.forEach(el_node => {
			ul.append(createTreeNode(el_node));
		})

		return ul;
	}

	/**
	 * Создает внутреннее предстваление для узла
	 * @param node
	 * @return {HTMLLIElement}
	 */
	function createTreeNode(node)
	{
		const template = `<div class="tree-node">
			<div class="tree-node-control">
				<button data-move="${node.id}"><i class="icon move"></i></button>
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
		li.dataset.title = node.title;
		li.dataset.desc = node.desc;
		li.classList.add('hide-inner-node');
		if (node.child && node.child.length)
		{
			const button = document.createElement('button');
			button.innerHTML = '<i class="icon"></i>';
			button.dataset.toggler = node.id;
			button.classList.add('folder')
			li.querySelector('.node-title__control').prepend(button);
			li.append(
				createTree(node.child)
			);
		}
		return li;
	}


	function toggleVisibility(initiator)
	{
		const id = initiator.dataset.toggler;
		const toggleNode = document.querySelector(`li[data-toggle="${id}"]`);
		toggleNode.classList.toggle('hide-inner-node')
	}

	//todo удалить иконку, если удалили единственного ребенка
	function deleteNode(initiator)
	{
		const id = initiator.dataset.delete;

		if (confirm('Удалить элемент?'))
		{
			fetch_anim(true);
			fetch('/api/list', {
				method: 'DELETE',
				body: JSON.stringify({ id: id })
			})
			.then(resp => {
				if (resp.status >= 200 && resp.status < 300)
				{
					let parentList = initiator.closest('ul');
					let countSisterly = parentList.childNodes.length;
					//Удалем все вместе с сестринскими элементами
					if (countSisterly === 1)
					{
						parentList.remove();
					}
					//удаляем только себя
					else
					{
						initiator.closest('li').remove();
					}
				}
			})
			.catch(err => console.log(err))
			.finally(()=>{ fetch_anim(); })
		}
	}

	function createDialog(parentNode, id)
	{
		modalBox.show((nodeFields)=>{
			fetch_anim(true);
			fetch('/api/list', {
				method: 'POST',
				body: JSON.stringify({
					title: nodeFields.title,
					desc: nodeFields.desc,
					pid: id,
				})
			})
				.then(resp => {
					if (resp.status >= 200 && resp.status < 300)
					{
						resp.json()
							.then(data => {
								nodeFields.id = data.id;
								if (parentNode.nodeName == 'UL')
								{
									parentNode.append(createTreeNode(nodeFields));
								}
								else if (parentNode.nodeName == 'LI')
								{
									let list = parentNode.querySelector('ul');
									if (list)
									{
										//Добавление в этот список
										list.append(createTreeNode(nodeFields));
										parentNode.classList.remove('hide-inner-node');
									}
									else
									{
										//Создание списка
										parentNode.append(
											createTree([nodeFields])
										)
										const btn = document.createElement('button');
										btn.innerHTML = '<i class="icon"></i>';
										btn.dataset.toggler = id;
										btn.classList.add('folder')
										parentNode.querySelector('.node-title__control').prepend(btn);
										parentNode.classList.remove('hide-inner-node');
									}
								}
								modalBox.hide();
							})
					}
				})
				.catch(err => console.log(err))
				.finally(()=>{ fetch_anim(); })
		});
	}

	function createNewNode(initiator)
	{
		const id = initiator.closest('li').dataset.toggle;
		createDialog(initiator.closest('li'), parseInt(id));
	}

	function editNode(initiator)
	{
		const id = initiator.dataset.edit;
		const node = initiator.closest(`li[data-toggle="${id}"]`);
		modalBox.show((nodeFields)=>{
			fetch_anim(true);
			fetch('/api/list', {
				method: 'PATCH',
				body: JSON.stringify({
					title: nodeFields.title,
					desc: nodeFields.desc,
					id: parseInt(id),
				})
			})
				.then(resp => {
					if (resp.status >= 200 && resp.status < 300)
					{
						node.dataset.title = nodeFields.title;
						node.dataset.desc = nodeFields.desc;
						node.querySelector('.node-title__title').innerText = nodeFields.title;
						node.querySelector('.node-desc').innerText = nodeFields.desc;
						modalBox.hide();
					}
				})
				.catch(err => console.log(err))
				.finally(()=>{ fetch_anim(); })
			},
			{
				title: node.dataset.title,
				desc: node.dataset.desc
			});
	}

	function moveNode(node, target)
	{
		if (node.dataset.toggle === target.dataset.toggle) return;
		fetch_anim(true);
		fetch('/api/list/move', {
				method: 'PATCH',
				body: JSON.stringify({
					to_id: parseInt(target.dataset.toggle),
					id: parseInt(node.dataset.toggle),
				})
			})
			.then(resp => {
				if (resp.status >= 200 && resp.status < 300)
				{
					let targetChild = target.querySelector('ul');
					if (targetChild) //Вставляем в список
					{
						targetChild.append(node);
					}
					else
					{
						//Создаем список и вставляем в него
						const ul = document.createElement('ul');
						ul.classList.add('tree');
						ul.append(node);
						const btn = document.createElement('button');
						btn.innerHTML = '<i class="icon"></i>';
						btn.dataset.toggler = node.dataset.toggle;
						btn.classList.add('folder')
						target.querySelector('.node-title__control').prepend(btn);
						target.classList.remove('hide-inner-node');
						target.append(ul);
					}
				}
			})
			.catch(err => console.log(err))
			.finally(()=>{ fetch_anim(); })
	}

	document.addEventListener('click', function (event){
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
			if (button.dataset.toggler) //Обработчик для переключателя ветки
			{
				toggleVisibility(button);
			}
			else if (button.dataset.delete) //Обработчик для кнопки удаления
			{
				deleteNode(button);
			}
			else if (button.dataset.addTo) //Обработчик добавления
			{
				createNewNode(button);
			}
			else if (button.dataset.edit) //Обработчик редактирования
			{
				editNode(button);
			}
			else if (button.dataset.addRoot)	//добавление в корневой раздел
			{
				createDialog(document.querySelector('main > ul.tree'), null);
			}
		}
	});
	//Реализация перемещения узлов перетаскиванием
	document.addEventListener('mousedown', function (event){
		let button;
		if (event.target.nodeName === 'BUTTON')
		{
			button = event.target;
		}
		else if (event.target.nodeName === 'I' && event.target.parentNode.nodeName === 'BUTTON')
		{
			button = event.target.parentNode;
		}

		if (button?.dataset?.move)
		{
			const el = button.closest('li[data-title]');
			el.classList.add('movement');
			const followCursor = (x, y) => {
				el.style.left = (x + 5) + 'px';
				el.style.top  = y - el.offsetHeight / 2 + 'px';
			};
			const onMouseMove = (event) =>{
				followCursor(event.pageX, event.pageY);
			};
			const onMouseUp = (event) => {
				el.classList.remove('movement');
				const target = event.target.closest('li[data-title]');
				if (target)
				{
					moveNode(el, target);
				}
				document.removeEventListener('mousemove', onMouseMove);
				document.removeEventListener('mouseup', onMouseUp);
			};
			document.addEventListener('mousemove', onMouseMove);
			document.addEventListener('mouseup', onMouseUp);
		}
	});
}

document.addEventListener('DOMContentLoaded', ()=>{
	treeView()
});
