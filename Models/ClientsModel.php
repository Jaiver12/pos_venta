<?php
	class ClientsModel extends Query
	{
		private $id;
		private $dni;
		private $name;
		private $phone;
		private $addres;
		private $status;

		public function __construct()
		{
			parent::__construct();
		}

		public function getClientAll()
		{
		    $sql = "SELECT * FROM client";
		    $data = $this->selectAll($sql);
		    return $data;
		}

		public function saveClient($dni, $name, $phone, $addres)
		{
			$this->dni = $dni;
			$this->name = $name;
			$this->phone = $phone;
			$this->addres = $addres;

			$sql = "INSERT INTO client(dni, name, phone, addres) VALUES (?,?,?,?)";
			$datas = array($this->dni,$this->name,$this->phone,$this->addres);
			$data = $this->save($sql, $datas);
			if($data == 1) {
		    	$res = "ok";
		    } else {
				$res = "error";
		    }
		    return $res;
		}

		public function editClient($id)
		{
		    $sql = "SELECT * FROM client WHERE id = $id";
		    $data = $this->select($sql);
		    return $data;
		}

		public function updateClient($id, $dni, $name, $phone, $addres)
		{
			$this->id = $id;
			$this->dni = $dni;
			$this->name = $name;
			$this->phone = $phone;
			$this->addres = $addres;

		    $sql = "UPDATE client SET dni = ?, name = ?, phone = ?, addres = ? WHERE id = ?";
		    $datas = array($this->dni, $this->name, $this->phone, $this->addres, $this->id);
		    $data = $this->save($sql, $datas);
		    if($data == 1) {
		    	$res = "modificado";
		    } else {
				$res = "error";
		    }

		    return $res;
		}

		public function deleteClient($id)
		{
		    $this->id = $id;
			$select = "SELECT * FROM client WHERE id = $id";
			$result = $this->select($select);

			if ($result['status'] == 1) {
				$sql = "UPDATE client SET status = 0 WHERE id = ?";
			} else {
		    	$sql = "UPDATE client SET status = 1 WHERE id = ?";
			}
		    $datas = array($this->id);
		    $data = $this->save($sql, $datas);
		    return $data;
		}
	}