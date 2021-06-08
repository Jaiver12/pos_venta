<?php
	class CajasModel extends Query
	{
		private $id;
		private $name;
		private $status;

		public function __construct()
		{
			parent::__construct();
		}

		public function getCajasAll()
		{
		    $sql = "SELECT * FROM caja";
		    $data = $this->selectAll($sql);
		    return $data;
		}

		public function saveCaja($name)
		{
			$this->name = $name;

			$sql = "INSERT INTO caja(caja) VALUES (?)";
			$datas = array($this->name);
			$data = $this->save($sql, $datas);
			if($data == 1) {
		    	$res = "ok";
		    } else {
				$res = "error";
		    }
		    return $res;
		}

		public function editCaja($id)
		{
		    $sql = "SELECT * FROM caja WHERE id = $id";
		    $data = $this->select($sql);
		    return $data;
		}

		public function updateCaja($id, $name)
		{
			$this->id = $id;
			$this->name = $name;

		    $sql = "UPDATE caja SET caja = ? WHERE id = ?";
		    $datas = array($this->name, $this->id);
		    $data = $this->save($sql, $datas);
		    if($data == 1) {
		    	$res = "modificado";
		    } else {
				$res = "error";
		    }

		    return $res;
		}

		public function deleteCaja($id)
		{
		    $this->id = $id;
			$select = "SELECT * FROM caja WHERE id = $id";
			$result = $this->select($select);

			if ($result['estado'] == 1) {
				$sql = "UPDATE caja SET estado = 0 WHERE id = ?";
			} else {
		    	$sql = "UPDATE caja SET estado = 1 WHERE id = ?";
			}
		    $datas = array($this->id);
		    $data = $this->save($sql, $datas);
		    return $data;
		}
	}