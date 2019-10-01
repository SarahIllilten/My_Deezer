<?php

require_once 'Core'.DIRECTORY_SEPARATOR.'ORM.php';

class TrackModel extends ORM {

	public $id;
	
	public function __construct($param=null) {
		parent::__construct();
		$this->id = $param;
	}

	public function get_track_data() {
		return $this->read('tracks', $this->id);
	}

	public function get_tracks($album, $limit=null) {
		if($limit==null) {
			$limit = 0;
		}
		$this->prep_query('SELECT * FROM tracks WHERE album_id=:id LIMIT '.$limit.',30');
		$this->bindData(':id', $album);
		$result = $this->getMultipleValue();
		foreach ($result as $key => $value) {
			foreach ($value as $key2 => $value2) {
				if($key2=='duration') {
					$result[$key][$key2]=floor($value2/60).':'.($value2%60);
				}
			}
		}
		return $result;
	}
	public function find_track($name, $limit=null) {
		if($limit==null) {
			$limit = 0;
		}
		return $this->find('tracks', $name, $limit);
	}

	public function find_track_album($id, $limit=null) {
		if($limit==null) {
			$limit = 0;
		}
		$this->prep_query('SELECT * FROM tracks WHERE album_id=:id LIMIT '.$limit.',30');
		$this->bindData(':id', $id);
		return $this->getMultipleValue();
	}
}