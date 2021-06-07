<?php
	class Users extends Controller
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

			$data['cajas'] = $this->model->getCajas();
			$this->views->getView($this, "index", $data);
		}

		public function listar()
		{
			$data = $this->model->getUsersAll();
			for ($i=0; $i < count($data) ; $i++) {
				if($data[$i]['status'] == 1) {
					$data[$i]['status'] = '<span class="badge bg-success">Activo</span>';
				} else {
					$data[$i]['status'] = '<span class="badge bg-danger">Inactivo</span>';
				}

				$data[$i]['acciones'] = '<div>
					<button class="btn btn-primary" type="button" onclick="btnEditUser('.$data[$i]['id'].');"><i class="fas fa-edit"></i></button>
					<button class="btn btn-secondary" type="button" onclick="btnDeleteUser('.$data[$i]['id'].');">Estado</button>
				</div>';
			}
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function register()
		{
			$user = $_POST['user'];
			$name = $_POST['name'];
			$password = $_POST['password'];
			$confirm = $_POST['confirm'];
			$caja = $_POST['caja'];
			$id = $_POST['id'];

			if($user == "" || $name == "" || $caja == "") {
				$msg = "Todos los campos son obligatorios";
			} else {
				if ($id == "") {
					if ($password != $confirm) {
						$msg = "Las contraseña no son iguales";
					} else {
						$hash = hash("SHA256", $password);

						$data = $this->model->saveUser($user, $name, $hash, $caja);
						if ($data == "ok") {
							$msg = "si";
						} else if ($data == "existe") {
							$msg = "El usuario ya existe";
						} else {
							$msg = "No se puedo regustrar el usuario";
						}
					}
				} else {
					$data = $this->model->updateUser($id, $user, $name, $caja);
					if ($data == "modificado") {
						$msg = "modificado";
					} else {
						$msg = "No se puedo actualizar el usuario";
					}
				}
			}
			echo json_encode($msg, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function validate()
		{
			if (empty($_POST['user']) || empty($_POST['password'])) {
				$msg = "Verifique si alguno de los campos estan vacios";
			} else {
				$user = $_POST['user'];
				$password = $_POST['password'];
				$hash = hash("SHA256", $password);
				$data = $this->model->getUser($user, $hash);

				if ($data) {
					$_SESSION['user_id'] = $data['id'];
					$_SESSION['user'] = $data['user'];
					$_SESSION['name'] = $data['name'];
					$_SESSION['activo'] = true;
					$msg = "ok";
				} else {
					$msg = "Usuario o contraseña invalidos";
				}
			}
			echo json_encode($msg, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function edit($id)
		{
			$data = $this->model->editUser($id);
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function delete($id)
		{

			$data = $this->model->deleteUser($id);
			if ($data == 1) {
				$msg = "ok";
			} else {
				$msg = "No se pudo modifical el estado del usuario";
			}
			echo json_encode($msg, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function logout()
		{
			session_destroy();
			header("location: ".BASE_URL);
		}
	}
