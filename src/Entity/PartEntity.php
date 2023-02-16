<?php

namespace App\Entity;

class PartEntity
{
	private $id = null;
	private $title;
	private $desc;
	private $pid = null;

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param mixed $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @return mixed
	 */
	public function getDesc()
	{
		return $this->desc;
	}

	/**
	 * @param mixed $desc
	 */
	public function setDesc($desc)
	{
		$this->desc = $desc;
	}

	/**
	 * @return mixed
	 */
	public function getPid()
	{
		return $this->pid;
	}

	/**
	 * @param mixed $pid
	 */
	public function setPid($pid)
	{
		$this->pid = $pid;
	}

}
