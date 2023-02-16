<?php

namespace App\Controller;

use App\Entity\PartEntity;
use App\Exceptions\AccessDeniedException;
use App\Services\PartService;

class Api  extends Controller
{
	use SecureTrait;

	public function __construct(...$args)
	{
		parent::__construct(...$args);
		//Проверка аутентификации
//		if (!$this->checkAuthCoolie())
//		{
//			throw new AccessDeniedException('Доступ запрещен');
//		}
	}

	/**
	 * Возвращает древовидный список
	 * @param PartService $partService
	 * @return \App\Http\Response JSON
	 */
	public function get_list(PartService $partService)
	{
		$tree = $partService->getTreeArray();
		return $this->renderJson([
			'treeList' => $tree
		]);
	}

	public function add_node(PartService $partService)
	{
		$data = $this->request->getBody();
		$part = new PartEntity();
		$part->setTitle($data['title']);
		$part->setDesc($data['desc']);
		$part->setPid($data['pid']);
		$part = $partService->addPart($part);
		return $this->renderJson(['id' => $part->getId()], 201);
	}

	public function update_node(PartService $partService)
	{
		$data = $this->request->getBody();
		$part = $partService->getOne(['id' => $data['id']]);
		$part->setTitle($data['title']);
		$part->setDesc($data['desc']);
		$partService->savePart($part);
		return $this->renderJson([], 204);
	}

	public function delete_chain(PartService $partService)
	{
		$data = $this->request->getBody();
		$partService->deletePartChain($data['id']);
		return $this->renderJson([], 204);
	}

	public function move_node(PartService $partService)
	{
		$data = $this->request->getBody();
		$partService->movePart($data['id'], $data['to_id']);
		return $this->renderJson([], 204);
	}

}
