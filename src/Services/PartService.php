<?php

namespace App\Services;

use App\Entity\PartEntity;

class PartService extends Service
{
	/**
	 * @return array Список всех разделов
	 */
	public function getAllParts()
	{
		return $this->getRepository()->findAll();
	}

	/**
	 * @return array Возвращает древовидную структуру разделов
	 */
	public function getTreeArray()
	{
		$flat = $this->getAllParts();
		if (is_null($flat))
		{
			return [];
		}
		return $this->flat2Tree($flat);
	}

	/**
	 * Преобразут плоский список в древовидную структуру
	 * @param $data
	 * @param null $pid
	 * @return array
	 */
	protected function flat2Tree(&$data, $pid = null)
	{
		$tree = [];
		foreach ($data as $n => $node)
		{
			if ($node->getPid() == $pid)
			{
				$arrayNode = [
					'id' => $node->getId(),
					'title' => $node->getTitle(),
					'desc' => $node->getDesc()
				];
				$child = $this->flat2Tree($data, $node->getId());
				if (!empty($child))
				{
					$arrayNode['child'] = $child;
				}
				$tree[] = $arrayNode;
			}
		}
		return $tree;
	}

	public function getOne($condition)
	{
		return $this->getRepository()->findOne($condition);
	}

	public function addPart(PartEntity $part)
	{
		return $this->getRepository()->saveEntity($part);
	}

	public function savePart(PartEntity $part)
	{
		return $this->getRepository()->saveEntity($part);
	}

	/**
	 * @param $flatList
	 * @param $id
	 * @return array массив id узла и потомков
	 */
	protected function calculateChildren(&$flatList, $id)
	{
		$list = [$id];
		foreach ($flatList as $n => $part)
		{
			if (in_array($part->getPid(), $list))
			{
				$list[] = $part->getId();
			}
		}
		return $list;
	}
	//Удаление узла
	public function deletePartChain($id)
	{
		$flat = $this->getAllParts();
		$chain = $this->calculateChildren($flat, $id);
		return $this->getRepository()->removeLst($chain);
	}

	/**
	 * Перемещение узлов
	 * @param $id
	 * @param $toId
	 */
	public function movePart($id, $toId)
	{
		$part = $this->getOne(['id' => $id]);
		$part->setPid($toId);
		return $this->getRepository()->saveEntity($part);
	}

}
