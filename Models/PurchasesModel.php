<?php
	class PurchasesModel extends Query
	{
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

	}