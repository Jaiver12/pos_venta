<?php
	class Connect {
		protected $conn;

		public function __construct()
		{
			$pdo = "mysql:host=". HOST .";dbname=".DB_NAME.";charset.";

			try {
				$this->conn = new PDO($pdo, USER, PASSWORD);
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				echo "Error en la conexion ". $e->getMessage();
			}
		}

		public function conn()
		{
			return $this->conn;
		}
	}