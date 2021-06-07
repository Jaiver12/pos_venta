<?php
	class Medidas extends Controller
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
			$data = $this->model->getMedidasAll();
			for ($i=0; $i < count($data) ; $i++) {
				if($data[$i]['status'] == 1) {
					$data[$i]['status'] = '<span class="badge bg-success">Activo</span>';
				} else {
					$data[$i]['status'] = '<span class="badge bg-danger">Inactivo</span>';
				}

				$data[$i]['acciones'] = '<div>
					<button class="btn btn-primary" type="button" onclick="btnEditMedida('.$data[$i]['id'].');"><i class="fas fa-edit"></i></button>
					<button class="btn btn-secondary" type="button" onclick="btnDeleteMedida('.$data[$i]['id'].');">Estado</button>
				</div>';
			}
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function register()
		{
		    $id = $_POST['id'];
		    $name = $_POST['name'];
		    $namecorto = $_POST['namecorto'];

		    if ($name == "" || $namecorto = "")
		    {
		    	$msg = "Todos los campos son obligatorios";
		    } else {
		    	if ($id == "") {
			    	$data = $this->model->saveMedida($name, $namecorto);
			    	if ($data == "ok") {
			    		$msg = "si";
			    	} else {
			    		$msg = "No se puedo registrar la medida";
			    	}
		    	} else {
		    		$data = $this->model->updateMedida($id, $name, $namecorto);
		    		if ($data == "modificado") {
		    			$msg = "modificado";
		    		} else {
		    			$msg = "No se puedo actualizar la medida";
		    		}
		    	}
		    }
		    echo json_encode($msg, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function edit($id)
		{
			$data = $this->model->editMedida($id);
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function delete($id)
		{
			$data = $this->model->deleteMedidas($id);
			if ($data == 1) {
				$msg = "ok";
			} else {
				$msg = "No se pudo modifical el estado de la Medida";
			}
			echo json_encode($msg, JSON_UNESCAPED_UNICODE);
			die();
		}

	}
