<?php
	require_once 'Config/Config.php';

	$ruta = !empty($_GET['url']) ? $_GET['url'] : "Home/index";
	$array = explode("/", $ruta);
	$controller = $array[0];
	$method = "index";
	$params = "";

	if(!empty($array[1])) {
		if(!empty($array[1] != "")) {
			$method = $array[1];
		}
	}

	if(!empty($array[2])){
		if(!empty($array[2] != "")){
			for ($i=2; $i < count($array) ; $i++) {
				$params .= $array[$i]. ",";
			}
			$params = trim($params, ",");
		}
	}

	require_once 'Config/App/autoload.php';

	$dirControllers = 'Controllers/' . $controller . '.php';
	if(file_exists($dirControllers)){
		require_once $dirControllers;
		$controller = new $controller();
		if(method_exists($controller, $method)){
			$controller->$method($params);
		} else {
			echo "el metodo no existe";
		}
	} else {
		echo "No Existe el controlador";
	}