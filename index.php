<?php
//Demande d'envoi des la réponse au format JSON
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

//Definition de la base de l'URL
define('BASE_URI', substr($_SERVER['REQUEST_URI'], 0, strripos($_SERVER['REQUEST_URI'], '/')));
//définition des constantes de connexion à la base de donnée
$db = json_decode(file_get_contents('Core'.DIRECTORY_SEPARATOR.'db.json'), true);
foreach ($db as $key => $value) {
	define($key, $value);
}
//Lancement de l'app et orientation en fonction de l'URL
require_once('Core'.DIRECTORY_SEPARATOR.'Router.php');
$route = new Router();

?>