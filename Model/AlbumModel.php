<?php
require_once 'Core'.DIRECTORY_SEPARATOR.'ORM.php';

class AlbumModel extends ORM {
	public $id;
	
	public function __construct($param=null) {
		parent::__construct();
		$this->id = $param;
	}

	public function get_album_data() {
		$this->prep_query('SELECT albums.*, artists.name AS \'artist_name\' FROM albums LEFT JOIN artists on artists.id=albums.artist_id WHERE albums.id= :id');
		$this->bindData(':id', $this->id);
		return $this->getSingleValue();
	}

	public function get_albums($limit=null) {
		if($limit==null) {
			$limit = 0;
		}
		$fields = "id, name";
		return $this->read_all('albums', $limit, $fields);
	}

	public function get_albums_artist($artist, $limit=null) {
		if($limit==null) {
			$limit = 0;
		}
		$this->prep_query('SELECT * FROM albums WHERE artist_id=:id LIMIT '.$limit.',30');
		$this->bindData(':id', $artist);
		return $this->getMultipleValue();
	}
	public function get_albums_genre($genre, $limit=null) {
		if($limit==null) {
			$limit = 0;
		}
		$this->prep_query('SELECT albums.* FROM albums LEFT JOIN genres_albums ON genres_albums.album_id=albums.id WHERE genres_albums.genre_id= :id LIMIT '.$limit.',30');
		$this->bindData(':id', $genre);
		return $this->getMultipleValue();
	}

	public function find_album($name, $limit=null) {
		if($limit==null) {
			$limit = 0;
		}
		return $this->find('albums', $name, $limit);
	}

	public function get_albums_rand($in) {
		$this->prep_query('SELECT albums.*, artists.name AS \'artist_name\' FROM albums LEFT JOIN artists on artists.id=albums.artist_id WHERE albums.id IN ('.$in.')');
		return $this->getMultipleValue();
	}

	public function get_album_count_total() {
		$this->prep_query('SELECT count(*) AS \'total\' FROM albums');
		return $this->getSingleValue();
	}
}

?>