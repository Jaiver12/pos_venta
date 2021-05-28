<?php
	class Clients extends Controller
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
			$data = $this->model->getClientAll();
			for ($i=0; $i < count($data) ; $i++) {
				if($data[$i]['status'] == 1) {
					$data[$i]['status'] = '<span class="badge bg-success">Activo</span>';
				} else {
					$data[$i]['status'] = '<span class="badge bg-danger">Inactivo</span>';
				}

				$data[$i]['acciones'] = '<div>
					<button class="btn btn-primary" type="button" onclick="btnEditClient('.$data[$i]['id'].');"><i class="fas fa-edit"></i></button>
					<button class="btn btn-secondary" type="button" onclick="btnDeleteClient('.$data[$i]['id'].');">Estado</button>
				</div>';
			}
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function register()
		{
		    $id = $_POST['id'];
		    $dni = $_POST['dni'];
		    $name = $_POST['name'];
		    $phone = $_POST['phone'];
		    $addres = $_POST['addres'];

		    if ($dni == "" || $name == "" || $phone == "" || $addres == "")
		    {
		    	$msg = "Todos los campos son obligatorios";
		    } else {
		    	if ($id == "") {
			    	$data = $this->model->saveClient($dni, $name, $phone, $addres);
			    	if ($data == "ok") {
			    		$msg = "si";
			    	} else {
			    		$msg = "No se puedo registrar el cliente";
			    	}
		    	} else {
		    		$data = $this->model->updateClient($id, $dni, $name, $phone, $addres);
		    		if ($data == "modificado") {
		    			$msg = "modificado";
		    		} else {
		    			$msg = "No se puedo actualizar el cliente";
		    		}
		    	}
		    }
		    echo json_encode($msg, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function edit($id)
		{
			$data = $this->model->editClient($id);
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function delete($id)
		{
			$data = $this->model->deleteClient($id);
			if ($data == 1) {
				$msg = "ok";
			} else {
				$msg = "No se pudo modifical el estado del usuario";
			}
			echo json_encode($msg, JSON_UNESCAPED_UNICODE);
			die();
		}

	}
