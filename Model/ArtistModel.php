<?php
require_once 'Core'.DIRECTORY_SEPARATOR.'ORM.php';

class ArtistModel extends ORM {
	public $id;
	
	public function __construct($param=null) {
		parent::__construct();
		$this->id = $param;
	}

	public function get_artist_data() {
		return $this->read('artists', $this->id);
	}

	public function get_artists($limit=null) {
		if($limit==null) {
			$limit = 0;
		}
		$fields = "id, name";
		return $this->read_all('artists', $limit, $fields);
	}
	public function find_artist($name, $limit=null) {
		if($limit==null) {
			$limit = 0;
		}
		return $this->find('artists', $name, $limit);
	}
}

?>