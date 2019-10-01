<?php

class Router {

// controller par défaut et méthode par défaut qui sont lancés à l'arrivée sur le site
	protected $controller ='ErrorController';
	protected $action = 'main';
	// les paramètre de la méthode
	protected $params = [];

	public function __construct() {
		require_once 'Controller.php';
		if(!empty($_GET)) {
			// si le 1e morceau de l'url est un fichier du dossier controller, $controller prend cette nouvelle valeur
			if(isset($_GET['controller'])) {
				if (file_exists('Controller'.DIRECTORY_SEPARATOR.$_GET['controller'].'Controller.php')) {
					$this->controller = $_GET['controller'].'Controller';
				}
			}
			//on require le controlleur, qu'il soit resté à sa valeur par défaut, ou qu'il en ai pris une nouvelle
			require_once 'Controller'.DIRECTORY_SEPARATOR.$this->controller.'.php';
			// on crée une nouvelle instance de la class du contolleur (si $controller=home, on va crer une nouvelle instance de la classe Home());
			$this->controller = new $this->controller;
			// si c'est le cas, on vérifie si cette variable est bien le nom d'une méthode de la classe du contolleur, et si c'est la cas $action prend la valeur de la methode passé en url
			if(isset($_GET['action'])) {
				if(method_exists($this->controller, $_GET['action'].'Action')) {
					$this->action = $_GET['action'].'Action';
				} else {
					$this->controller = 'ErrorController';
					require_once 'Controller'.DIRECTORY_SEPARATOR.$this->controller.'.php';
					$this->controller = new $this->controller;
					$this->action = $this->action.'Action';
				}
				// on vérifie si l'url comportent des parametres, si c'est le cas, on les passe dans l'array $params
				if(count($_GET)>2) {
					foreach ($_GET as $key => $value) {
		 				if($key!='controller' && $key!='action') {
		 					$this->params[$key]=$this->secure_param($_GET[$key]);
		 				}
					}
				}
			} else {
				$this->controller = 'ErrorController';
				require_once 'Controller'.DIRECTORY_SEPARATOR.$this->controller.'.php';
				$this->controller = new $this->controller;
				$this->action = $this->action.'Action';
			}
		} else {
			//si pas de controller, alors redirection vers le controller d'erreur
			require_once 'Controller'.DIRECTORY_SEPARATOR.$this->controller.'.php';
			$this->controller = new $this->controller;
			$this->action = $this->action.'Action';
		}
		// on appelle la méthode de l'objet de notre controller avec les parametres passés en url
		$this->controller->{$this->action}($this->params);
	}

	private function secure_param($param) {
		return htmlspecialchars(trim($param));
	}
}