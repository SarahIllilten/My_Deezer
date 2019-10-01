<?php
require_once 'Core'.DIRECTORY_SEPARATOR.'ORM.php';

class GenreModel extends ORM {
	public $id;
	
	public function __construct($param=null) {
		parent::__construct();
		$this->id = $param;
	}

	public function get_genre_data() {
		// $this->prep_query('SELECT genres.*, genres.name AS \'genre_name\', albums.*, genres_albums.*, albums.name AS \'album_name\' FROM genres LEFT JOIN genres_albums ON genres.id=genres_albums.genre_id LEFT JOIN albums ON genres_albums.album_id=albums.id WHERE genres.id= :id');
		// $this->bindData(':id', $this->id);
		// return $this->getMultipleValue();
		return $this->read('genres', $this->id);
	}

	public function get_genres($limit=null) {
		if($limit==null) {
			$limit = 0;
		}
		$fields = "id, name";
		return $this->read_all('genres', $limit, $fields);
	}
	public function find_genre($name, $limit=null) {
		if($limit==null) {
			$limit = 0;
		}
		return $this->find('genres', $name, $limit);
	}
}

?>