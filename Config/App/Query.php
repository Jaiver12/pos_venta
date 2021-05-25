<?php
	class Query extends Connect {
		private $pdo;
		private $con;
		private $sql;
		private $datas;

		public function __construct()
		{
			$this->pdo = new Connect();
			$this->con = $this->pdo->conn;
		}

		public function select($sql)
		{
		    $this->sql = $sql;
		    $result = $this->con->prepare($this->sql);
		    $result->execute();
		    $data = $result->fetch(PDO::FETCH_ASSOC);
		    return $data;
		}

		public function selectAll($sql)
		{
		    $this->sql = $sql;
		    $result = $this->con->prepare($this->sql);
		    $result->execute();
		    $data = $result->fetchAll(PDO::FETCH_ASSOC);
		    return $data;
		}

		public function save($sql, $datas)
		{
			$this->sql = $sql;
			$this->datas = $datas;
			$insert = $this->con->prepare($this->sql);
			$data = $insert->execute($this->datas);
			if($data) {
				$res = 1;
			} else {
				$res = 0;
			}
			return $res;
		}

	}