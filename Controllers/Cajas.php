<?php
	class Cajas extends Controller
	{
		public function __construct()
		{
		    session_start();
		    if (empty($_SESSION['activo'])) {
		    	header("location: ".BASE_URL);
		    }
		    parent::__construct();
		}

		public function index()
		{
			$this->views->getView($this, "index");
		}

		public function listar()
		{
			$data = $this->model->getCajasAll();
			for ($i=0; $i < count($data) ; $i++) {
				if($data[$i]['estado'] == 1) {
					$data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';
				} else {
					$data[$i]['estado'] = '<span class="badge bg-danger">Inactivo</span>';
				}

				$data[$i]['acciones'] = '<div>
					<button class="btn btn-primary" type="button" onclick="btnEditCaja('.$data[$i]['id'].');"><i class="fas fa-edit"></i></button>
					<button class="btn btn-secondary" type="button" onclick="btnDeleteCaja('.$data[$i]['id'].');">Estado</button>
				</div>';
			}
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function register()
		{
		    $id = $_POST['id'];
		    $name = $_POST['name'];

		    if ($name == "")
		    {
		    	$msg = "Todos los campos son obligatorios";
		    } else {
		    	if ($id == "") {
			    	$data = $this->model->saveCaja($name);
			    	if ($data == "ok") {
			    		$msg = "si";
			    	} else {
			    		$msg = "No se puedo registrar la caja";
			    	}
		    	} else {
		    		$data = $this->model->updateCaja($id, $name);
		    		if ($data == "modificado") {
		    			$msg = "modificado";
		    		} else {
		    			$msg = "No se puedo actualizar la caja";
		    		}
		    	}
		    }
		    echo json_encode($msg, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function edit($id)
		{
			$data = $this->model->editCaja($id);
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function delete($id)
		{
			$data = $this->model->deleteCaja($id);
			if ($data == 1) {
				$msg = "ok";
			} else {
				$msg = "No se pudo modifical el estado de la caja";
			}
			echo json_encode($msg, JSON_UNESCAPED_UNICODE);
			die();
		}

	}
