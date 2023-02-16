<?php

namespace App\Repository;

use App\Entity\PartEntity;

class PartRepository extends Repository
{
	public function findAll()
	{
		$sql = 'SELECT * FROM part';
		$res = $this->db->query($sql, [], PartEntity::class);
		return !empty($res) ? $res : null;
	}

	public function findOne($condition)
	{
		$sql = 'SELECT * FROM part WHERE ';
		$cnd = [];
		$data = [];
		foreach ($condition as $filed => $value)
		{
			$cnd[] = $filed . ' = :' . $filed;
			$data[ ':'.$filed ] = $value;
		}
		$sql .= implode(' AND ', $cnd);
		$res = $this->db->query($sql, $data, PartEntity::class);
		return !empty($res) ? $res[0] : null;
	}

	public function saveEntity(PartEntity $part)
	{
		$data = [
			':title' => $part->getTitle(),
			':desc'  => $part->getDesc(),
			':pid'   => $part->getPid(),
		];

		//добавление
		if ( is_null($part->getId()) )
		{
			$sql = 'INSERT INTO part (title, `desc`, pid) VALUES (:title, :desc, :pid)';
			$res = $this->db->insert($sql, $data);
			$part->setId($res['id']);
			return $res ? $part : false;
		}
		//Обновление
		else
		{
			$sql = 'UPDATE part SET title = :title, `desc` = :desc, pid = :pid WHERE id = :id';
			//unset($data[':pid']);
			$data[':id'] = $part->getId();
			$res = $this->db->update($sql, $data);
			return $res ? $part : false;
		}
	}

	public function removeLst($listId)
	{
		$sql = 'DELETE FROM part WHERE id IN ';
		//Собираем ключи и данные для PDO
		$keys = array_map(function($key){return ':id'.$key;}, $listId);
		$data = array_combine($keys, $listId);
		$sql .= '( ' . implode(', ', $keys) . ' )';
		$res = $this->db->remove($sql, $data);
		return $res;
	}
}
