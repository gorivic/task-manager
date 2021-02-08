<?php

/*
** Класс маршрутизации
*/

class Routing {

	public static function buildRoute() {

		$controllerName = "IndexController";
		$modelName = "IndexModel";
		$action = isset($_GET['modal']) ? $_GET['modal'] : "index";

		require_once CONTROLLER_PATH . $controllerName . ".php"; 
		require_once MODEL_PATH . $modelName . ".php"; 

		$controller = new $controllerName();
		$controller->$action(); 

	}

	public function errorPage() {

	}


}