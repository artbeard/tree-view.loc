<?php

namespace App\Services;

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

}
