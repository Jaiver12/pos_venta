<?php
	class SalesModel extends Query
	{
		private $id_user, $id_product, $price, $stock, $sub_total, $id;

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
		    $sql ="SELECT d.*, p.id AS id_pro, p.name FROM detaill d INNER JOIN products p ON d.id_product = p.id WHERE d.id_user = $id";
		    $data = $this->selectAll($sql);
		    return $data;
		}

		public function totalVenta($id)
		{
		    $sql ="SELECT SUM(sub_total) AS total FROM detaill WHERE id_user = $id";
		    $data = $this->select($sql);
		    return $data;
		}

		public function deleteDetail($id)
		{
			$this->id = $id;
		    $sql = "DELETE FROM detaill WHERE id = ?";
		    $datas = array($this->id);
		    $data = $this->delete($sql, $datas);
		    if ($data == 1) {
				$res = "ok";
			} else {
				$res = "error";
			}

			return $res;
		}

		public function consultDetail($id_product, $id_user)
		{
			$sql ="SELECT * FROM detaill WHERE id_product = $id_product AND id_user = $id_user";
		    $data = $this->select($sql);
		    return $data;
		}

		public function updateDetail($price, $stock, $sub_total, $id_product, $id_user)
		{
			$sql = "UPDATE detaill SET price = ?, stock = ?, sub_total = ? WHERE id_product = ? AND  id_user = ?";
			$datas = array($price, $stock, $sub_total, $id_product, $id_user);
			$data = $this->save($sql, $datas);
			if ($data == 1) {
				$res = "modificado";
			} else {
				$res = "error";
			}

			return $res;
		}

		public function register($total)
		{
		    $sql = "INSERT INTO sales (total) VALUES (?)";
			$datas = array($total);
			$data = $this->save($sql, $datas);
			if ($data == 1) {
				$res = "ok";
			} else {
				$res = "error";
			}

			return $res;
		}

		public function id_sales()
		{
		    $sql = "SELECT MAX(id) AS id FROM sales";
		    $data = $this->select($sql);
		    return $data;
		}

		public function registraDetail($id_sales, $id_product, $stock, $price, $sub_total)
		{
			$sql = "INSERT INTO detail_sales (id_sales, id_product, stock, price, sub_total) VALUES (?, ?, ?, ?, ?)";
			$datas = array($id_sales, $id_product, $stock, $price, $sub_total);
			$data = $this->save($sql, $datas);
			if ($data == 1) {
				$res = "ok";
			} else {
				$res = "error";
			}

			return $res;
		}

		public function getEmpresa()
		{
			$sql = "SELECT * FROM config";
		    $data = $this->select($sql);
		    return $data;
		}

		public function vaciarDetalle($id_user)
		{
			$sql = "DELETE FROM detaill WHERE id_user = ?";
			$datas = array($id_user);
			$data = $this->save($sql, $datas);
			if ($data == 1) {
				$res = "ok";
			} else {
				$res = "error";
			}

			return $res;
		}

		public function getProSales($id_sales)
		{
			$sql = "SELECT s.*, d.*, p.id, p.name FROM sales s INNER JOIN detail_sales d ON s.id = d.id_sales INNER JOIN products p ON p.id = d.id_product WHERE s.id = $id_sales";
			$data = $this->selectAll($sql);
			return $data;
		}

		public function historialVenta()
		{
		    $sql = "SELECT * FROM sales";
		    $data = $this->selectAll($sql);
		    return $data;
		}

		public function updateStock($id_product, $stock)
		{
			$sql = "UPDATE products SET stock = ? WHERE id = ?";
			$datas = array($stock, $id_product);
			$data = $this->save($sql, $datas);
			return $data;
		}

	}
