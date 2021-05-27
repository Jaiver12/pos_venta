<?php
	class UsersModel extends Query
	{
		private $user;
		private $name;
		private $password;
		private $id_caja;
		private $id;

		public function __construct()
		{
			parent::__construct();
		}

		public function getUsersAll()
		{
		    $sql = "SELECT u.*, c.id AS id_caja, c.caja FROM users u INNER JOIN caja c WHERE u.id_caja = c.id";
		    $data = $this->selectAll($sql);
		    return $data;
		}

		public function getUser($user, $password)
		{
			$sql = "SELECT * FROM users WHERE user = '$user' AND password = '$password'";
		    $data = $this->select($sql);
		    return $data;
		}

		public function getCajas()
		{
		    $sql ="SELECT * FROM caja WHERE estado = 1";
		    $data = $this->selectAll($sql);
		    return $data;
		}

		public function saveUser($user, $name, $password, $id_caja)
		{
			$this->user = $user;
			$this->name = $name;
			$this->password = $password;
			$this->id_caja = $id_caja;

			$verificar = "SELECT * FROM users WHERE user = '$this->user'";
			$existe = $this->select($verificar);

			if(empty($existe)){
			    $sql = "INSERT INTO users(user, name, password, id_caja) VALUES (?,?,?,?)";
			    $datas = array($this->user, $this->name, $this->password, $this->id_caja);
			    $data = $this->save($sql, $datas);
			    if($data == 1) {
			    	$res = "ok";
			    } else {
					$res = "error";
			    }
		    } else {
		    	$res = "existe";
		    }
		    return $res;
		}

		public function editUser($id)
		{
		    $sql = "SELECT * FROM users WHERE id = $id";
		    $data = $this->select($sql);
		    return $data;
		}

		public function updateUser($id, $user, $name, $id_caja)
		{
			$this->id = $id;
			$this->user = $user;
			$this->name = $name;
			$this->id_caja = $id_caja;

		    $sql = "UPDATE users SET user = ?, name = ?, id_caja = ? WHERE id = ?";
		    $datas = array($this->user, $this->name, $this->id_caja, $this->id);
		    $data = $this->save($sql, $datas);
		    if($data == 1) {
		    	$res = "modificado";
		    } else {
				$res = "error";
		    }

		    return $res;
		}

		public function deleteUser($id)
		{
			$this->id = $id;
			$select = "SELECT * FROM users WHERE id = $id";
			$result = $this->select($select);

			if ($result['status'] == 1) {
				$sql = "UPDATE users SET status = 0 WHERE id = ?";
			} else {
		    	$sql = "UPDATE users SET status = 1 WHERE id = ?";
			}
		    $datas = array($this->id);
		    $data = $this->save($sql, $datas);
		    return $data;
		}
	}
