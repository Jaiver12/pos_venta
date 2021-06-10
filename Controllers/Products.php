<?php
	class Products extends Controller
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

			$data['medidas'] = $this->model->getMedidas();
			$data['categories'] = $this->model->getCategories();
			$this->views->getView($this, "index", $data);
		}

		public function listar()
		{
			$data = $this->model->getProductsAll();
			for ($i=0; $i < count($data) ; $i++) {
				$data[$i]['image'] = '<img class="img-thumbnail" src="'. BASE_URL . "Assets/image/" . $data[$i]['img'] .'" width="100">';

				if($data[$i]['status'] == 1) {
					$data[$i]['status'] = '<span class="badge bg-success">Activo</span>';
				} else {
					$data[$i]['status'] = '<span class="badge bg-danger">Inactivo</span>';
				}

				$data[$i]['acciones'] = '<div>
					<button class="btn btn-primary" type="button" onclick="btnEditProduct('.$data[$i]['id'].');"><i class="fas fa-edit"></i></button>
					<button class="btn btn-secondary" type="button" onclick="btnDeleteProduct('.$data[$i]['id'].');">Estado</button>
				</div>';
			}
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function register()
		{
		    $id = $_POST['id'];
		    $codigo = $_POST['codigo'];
		    $name = $_POST['name'];
		    $description = $_POST['description'];
		    $price_comp = $_POST['price_comp'];
		    $price_vent = $_POST['price_vent'];
		    $id_medida = $_POST['id_medida'];
		    $id_category = $_POST['id_category'];

		    $img = $_FILES['img'];
		    $nameimg = $img['name'];
		    $tmpimg = $img['tmp_name'];
		    $fecha = date("YmdHis");

		    if ($codigo == "" || $name == "" || $description == "" || $price_comp == "" || $price_vent == "")
		    {
		    	$msg = "Todos los campos son obligatorios";
		    } else {
		    	if (!empty($nameimg)) {
		    		$imgName = $fecha . nameimg;
		    		$destino = "Assets/image/" . $imgName;
		    	} else {
		    		$imgName = "default.jpg";
		    	}

		    	if ($id == "") {
			    	$data = $this->model->saveProduct($codigo, $name, $description, $price_comp, $price_vent, $id_medida, $id_category, $imgName);

			    	if ($data == "ok") {
			    		$msg = "si";
			    		if (!empty($nameimg)) {
			    			move_uploaded_file($tmpimg, $destino);
			    		}
			    	} else {
			    		$msg = "No se puedo registrar la categoria";
			    	}
		    	} else {
		    		$imgDelete = $this->model->editProduct($id);
		    		if ($imgDelete['img'] != 'default.jpg' || $imgDelete['img'] != '') {
		    			if (file_exists("Assets/image/" . $imgDelete['img'])) {
		    				unlink("Assets/image/" . $imgDelete['img']);
		    			}
		    		}
		    		$data = $this->model->updateProduct($id, $codigo, $name, $description, $price_comp, $price_vent, $id_medida, $id_category, $imgName);
		    		if ($data == "modificado") {
		    			$msg = "modificado";
		    			if (!empty($nameimg)) {
			    			move_uploaded_file($tmpimg, $destino);
			    		}
		    		} else {
		    			$msg = "No se puedo actualizar la categoria";
		    		}
		    	}
		    }
		    echo json_encode($msg, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function edit($id)
		{
			$data = $this->model->editProduct($id);
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function delete($id)
		{
			$data = $this->model->deleteProduct($id);
			if ($data == 1) {
				$msg = "ok";
			} else {
				$msg = "No se pudo modifical el estado de la categoria";
			}
			echo json_encode($msg, JSON_UNESCAPED_UNICODE);
			die();
		}

	}
