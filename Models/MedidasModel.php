<?php
	class MedidasModel extends Query
	{
		private $id;
		private $name;
		private $namecorto;
		private $status;

		public function __construct()
		{
			parent::__construct();
		}

		public function getMedidasAll()
		{
		    $sql = "SELECT * FROM medidas";
		    $data = $this->selectAll($sql);
		    return $data;
		}

		public function saveMedida($name, $namecorto)
		{
			$this->name = $name;
			$this->namecorto = $namecorto;

			$sql = "INSERT INTO medidas(name, namecorto) VALUES (?, ?)";
			$datas = array($this->name, $this->namecorto);
			$data = $this->save($sql, $datas);
			if($data == 1) {
		    	$res = "ok";
		    } else {
				$res = "error";
		    }
		    return $res;
		}

		public function editMedida($id)
		{
		    $sql = "SELECT * FROM medidas WHERE id = $id";
		    $data = $this->select($sql);
		    return $data;
		}

		public function updateMedida($id, $name, $namecorto)
		{
			$this->id = $id;
			$this->name = $name;
			$this->namecorto = $namecorto;

		    $sql = "UPDATE medidas SET name = ?, namecorto = ? WHERE id = ?";
		    $datas = array($this->name, $this->namecorto, $this->id);
		    $data = $this->save($sql, $datas);
		    if($data == 1) {
		    	$res = "modificado";
		    } else {
				$res = "error";
		    }

		    return $res;
		}

		public function deleteMedidas($id)
		{
		    $this->id = $id;
			$select = "SELECT * FROM medidas WHERE id = $id";
			$result = $this->select($select);

			if ($result['status'] == 1) {
				$sql = "UPDATE medidas SET status = 0 WHERE id = ?";
			} else {
		    	$sql = "UPDATE medidas SET status = 1 WHERE id = ?";
			}
		    $datas = array($this->id);
		    $data = $this->save($sql, $datas);
		    return $data;
		}
	}