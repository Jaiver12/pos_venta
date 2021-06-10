<?php
	class ProductsModel extends Query
	{
		private $id;
		private $codigo;
		private $name;
		private $description;
		private $price_comp;
		private $price_vent;
		private $id_medida;
		private $id_category;
		private $status;
		private $img;

		public function __construct()
		{
			parent::__construct();
		}

		public function getProductsAll()
		{
		    $sql = "SELECT * FROM products";
		    $data = $this->selectAll($sql);
		    return $data;
		}

		public function getProducts()
		{
		    $sql = "SELECT p.*, m.id AS id_medida, m.name AS medida, c.id AS id_category, c.name AS category FROM products p INNER JOIN medidas m on p.id_medida = m.id INNER JOIN categories c ON p.id_category = c.id WHERE p.status = 1";
		    $data = $this->selectAll($sql);
		    return $data;
		}

		public function getMedidas()
		{
		    $sql ="SELECT * FROM medidas WHERE status = 1";
		    $data = $this->selectAll($sql);
		    return $data;
		}

		public function getCategories()
		{
		    $sql ="SELECT * FROM categories WHERE status = 1";
		    $data = $this->selectAll($sql);
		    return $data;
		}

		public function saveProduct($codigo, $name, $description, $price_comp, $price_vent, $id_medida, $id_category, $img)
		{
			$this->codigo = $codigo;
			$this->name = $name;
			$this->description = $description;
			$this->price_comp = $price_comp;
			$this->price_vent = $price_vent;
			$this->id_medida = $id_medida;
			$this->id_category = $id_category;
			$this->img = $img;

			$sql = "INSERT INTO products(codigo, name, description, price_comp, price_vent, id_medida, id_category, img) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
			$datas = array($this->codigo, $this->name, $this->description, $this->price_comp, $this->price_vent, $this->id_medida, $this->id_category, $this->img);
			$data = $this->save($sql, $datas);
			if($data == 1) {
		    	$res = "ok";
		    } else {
				$res = "error";
		    }

		    return $res;
		}

		public function editProduct($id)
		{
		    $sql = "SELECT * FROM products WHERE id = $id";
		    $data = $this->select($sql);
		    return $data;
		}

		public function updateProduct($id, $codigo, $name, $description, $price_comp, $price_vent, $id_medida, $id_category,  $img)
		{
			$this->id = $id;
			$this->codigo = $codigo;
			$this->name = $name;
			$this->description = $description;
			$this->price_comp = $price_comp;
			$this->price_vent = $price_vent;
			$this->id_medida = $id_medida;
			$this->id_category = $id_category;
			$this->img = $img;

		    $sql = "UPDATE products SET codigo = ?, name = ?, description = ?, price_comp = ?, price_vent = ?, id_medida = ?, id_category = ?, img = ? WHERE id = ?";
		    $datas = array($this->codigo, $this->name, $this->description, $this->price_comp, $this->price_vent, $this->id_medida, $this->id_category, $this->img, $this->id);
		    $data = $this->save($sql, $datas);
		    if($data == 1) {
		    	$res = "modificado";
		    } else {
				$res = "error";
		    }

		    return $res;
		}

		public function deleteProduct($id)
		{
		    $this->id = $id;
			$select = "SELECT * FROM products WHERE id = $id";
			$result = $this->select($select);

			if ($result['status'] == 1) {
				$sql = "UPDATE products SET status = 0 WHERE id = ?";
			} else {
		    	$sql = "UPDATE products SET status = 1 WHERE id = ?";
			}
		    $datas = array($this->id);
		    $data = $this->save($sql, $datas);
		    return $data;
		}
	}