<?php

require_once 'Database.php';

class ORM {

	public $stmt;
	public $db;

	public function __construct() {
		$this->db = Database::connect();
	}
		//***********PREPARATION ET EXECUSION DE LA REQUETE**********
	// Methode de preparation de la requete
	public function prep_query($query) {
		$this->stmt = $this->db->prepare($query);
	}
	// Methode d'association d'une value à un parametre (parametre qui sera présent dans la $query)
	public function bindData($param, $value, $type = null){
		if (is_null($type)) {
			switch (true) {
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
			}
		}
		$this->stmt->bindValue($param, $value, $type);
	}
	// Methode d'exécution d'une requête
	public function execute_query(){
	    return $this->stmt->execute();
	}
	//***********RECUPERATION DES RESULATS D'UN REQUETE**********
	// Methode de recupération d'une valeur
	public function getSingleValue(){
		$this->stmt->execute();
		return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}
	// Methode de recupération de plusieurValeur
	public function getMultipleValue(){
		$this->stmt->execute();
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	//***********TRANSACTIONS**********
	//Methode de lancement d'une transaction
	public function startTransaction(){
		return $this->db->beginTransaction();
	}

	//Methode de lancement d'une transaction
	public function sendTransaction(){
		return $this->db->commit();
	}
	// Méthode d'annulationd de la transaction (en cas d'erreur, pour le catch)
	public function cancelTransaction(){
		return $this->db->rollBack();
	}

	//***********OBTENIR DES INFO SUR UNE TABLE**********
	// Methode qui redtorune le nombre de ligne concernées c'est à dire modifiées, supprimées ou ajoutées lors de la dernière requête de modification, suppression ou ajout.
	public function getNbAffectedRow() {
		return $this->stmt->rowCount();
	}
	// Methode qui retourne le dernier ID inseré
	public function getLastInsertId() {
		return $this->db->lastInsertId();
	}

	//***********CRUDS**********
	public function read($table, $id) {
		$this->prep_query('SELECT * FROM '.$table.' WHERE id= :id');
		$this->bindData(':id', $id);
		return $this->getSingleValue();
	}
	public function read_all($table, $limit, $fields=null) {
		if($fields==null) {
			$fields = '*';
		}
		$this->prep_query('SELECT '.$fields.' FROM '.$table.' LIMIT '.$limit.',30');
		return $this->getMultipleValue();
	}
	public function find($table, $name, $limit) {
		$this->prep_query('SELECT id, name FROM '.$table.' WHERE name LIKE \'%'.$name.'%\' LIMIT '.$limit.',30');
		return $this->getMultipleValue();
	}
}

?>