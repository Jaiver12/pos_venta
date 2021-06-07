<?php
	class CategoriesModel extends Query
	{
		private $id;
		private $name;
		private $status;

		public function __construct()
		{
			parent::__construct();
		}

		public function getCategoriesAll()
		{
		    $sql = "SELECT * FROM categories";
		    $data = $this->selectAll($sql);
		    return $data;
		}

		public function saveCategory($name)
		{
			$this->name = $name;

			$sql = "INSERT INTO categories(name) VALUES (?)";
			$datas = array($this->name);
			$data = $this->save($sql, $datas);
			if($data == 1) {
		    	$res = "ok";
		    } else {
				$res = "error";
		    }
		    return $res;
		}

		public function editCategory($id)
		{
		    $sql = "SELECT * FROM categories WHERE id = $id";
		    $data = $this->select($sql);
		    return $data;
		}

		public function updateCategory($id, $name)
		{
			$this->id = $id;
			$this->name = $name;

		    $sql = "UPDATE categories SET name = ? WHERE id = ?";
		    $datas = array($this->name, $this->id);
		    $data = $this->save($sql, $datas);
		    if($data == 1) {
		    	$res = "modificado";
		    } else {
				$res = "error";
		    }

		    return $res;
		}

		public function deleteCategory($id)
		{
		    $this->id = $id;
			$select = "SELECT * FROM categories WHERE id = $id";
			$result = $this->select($select);

			if ($result['status'] == 1) {
				$sql = "UPDATE categories SET status = 0 WHERE id = ?";
			} else {
		    	$sql = "UPDATE categories SET status = 1 WHERE id = ?";
			}
		    $datas = array($this->id);
		    $data = $this->save($sql, $datas);
		    return $data;
		}
	}