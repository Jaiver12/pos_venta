<?php
	class PurchasesModel extends Query
	{
		private $id_user, $id_product, $price, $stock, $sub_total;

		public function __construct()
		{
			parent::__construct();
		}

		public function getProCod($cod)
		{
		    $sql = "SELECT * FROM products WHERE codigo = '$cod'";
		    $data = $this->select($sql);
		    return $data;

		}

		public function getProduct(int $id)
		{
			$sql = "SELECT * FROM products WHERE id = $id";
		    $data = $this->select($sql);
		    return $data;
		}

		public function addDetail($id_user, $id_product, $price, $stock, $sub_total)
		{
			$this->id_user = $id_user;
			$this->id_product = $id_product;
			$this->price = $price;
			$this->stock = $stock;
			$this->sub_total = $sub_total;

			$sql = "INSERT INTO detaill(id_user, id_product, price, stock, sub_total) VALUES (?, ?, ?, ?, ?)";
			$datas = array($this->id_user, $this->id_product, $this->price, $this->stock, $this->sub_total);
			$data = $this->save($sql, $datas);
			if ($data == 1) {
				$res = "ok";
			} else {
				$res = "error";
			}

			return $res;
		}

		public function getDetails($id)
		{
		    $sql ="SELECT d.*, p.id, p.name FROM detaill d INNER JOIN products p ON d.id_product = p.id WHERE d.id_user = $id";
		    $data = $this->selectAll($sql);
		    return $data;
		}

	}