<?php
	class Purchases extends Controller
	{
		public function __construct()
		{
		    session_start();

		    parent::__construct();
		}

		public function index()
		{
			if (empty($_SESSION['activo'])) {
		    	header("location: ".BASE_URL);
		    }
			$this->views->getView($this, "index");
		}

		public function searchCodigo($cod)
		{
			$data = $this->model->getProCod($cod);
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
		}

		public function addPurchase()
		{
		    $id = $_POST['id'];
		    $datas = $this->model->getProduct($id);
		    $id_user = $_SESSION['user_id'];
		    $id_product = $datas['id'];
		    $price = $datas['price_comp'];
		    $stock = $_POST['stock'];

		    $consult = $this->model->consultDetail($id_product, $id_user);

		    if (empty($consult)) {
		    	$sub_total = $price * $stock;
		    	$data = $this->model->addDetail($id_user, $id_product, $price, $stock, $sub_total);
			    if ($data == "ok") {
			    	$msg = "ok";
			    } else {
			    	$msg = "Error en la ingresar el producto";
			    }
		    } else {
		    	$newStock = $consult['stock'] + $stock;
		    	$sub_total = $price * $newStock;
		    	$data = $this->model->updateDetail($price, $newStock, $sub_total, $id_product, $id_user);
			    if ($data == "modificado") {
			    	$msg = "ok";
			    } else {
			    	$msg = "Error en la ingresar el producto";
			    }
		    }

		    echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		    die();
		}

		public function addDetails()
		{
			$id = $_SESSION['user_id'];
		    $data['detail'] = $this->model->getDetails($id);
		    $data['total'] = $this->model->totalCompra($id);
		    echo json_encode($data, JSON_UNESCAPED_UNICODE);
		}

		public function deleteDetails($id)
		{
		    $data = $this->model->deleteDetail($id);
		    if ($data == "ok") {
		    	$msg = "ok";
		    } else {
		    	$msg = "Error al eliminar el priducto";
		    }
		    echo json_encode($msg);
		    die();
		}

		public function register()
		{
			$id = $_SESSION['user_id'];
			$total = $this->model->totalCompra($id);
			$data = $this->model->register($total['total']);
			if ($data == "ok") {
				$details = $this->model->getDetails($id);
				$id_purchase = $this->model->id_purchase();
				foreach ($details as $detail) {
					$id_product = $detail['id_product'];
					$stock = $detail['stock'];
					$price = $detail['price'];
					$sub_total = $price * $stock;
					$this->model->registraDetail($id_purchase['id'], $id_product, $stock, $price, $sub_total);
				}
				$msg = "ok";
			} else {
				$msg = "error al hacer la compra";
			}

			echo json_encode($msg);
			die();
		}

	}
