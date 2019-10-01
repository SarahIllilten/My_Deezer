<?php

require_once 'Model'.DIRECTORY_SEPARATOR.'AlbumModel.php';
require_once 'Model'.DIRECTORY_SEPARATOR.'TrackModel.php';

class AlbumsController extends Controller {

	public function get_albums_listAction() {
		$album = new AlbumModel();
		$album_list = $album->get_albums();
		exit($this->render($album_list));
	}

	public function get_albums_artistAction($param) {
		if(!isset($param['id'])) {
			header('Location: '.BASE_URI.'?controller=Error&action=invalidArgument');
		}
		$album = new AlbumModel();
		$album_list = $album->get_albums_artist($param['id']);
		exit($this->render($album_list));
	}

	public function get_albumAction($param) {
		if(!isset($param['id'])) {
			header('Location: '.BASE_URI.'?controller=Error&action=invalidArgument');
		}
		$album = new AlbumModel($param['id']);
		$album_data = $album->get_album_data();
		$album_data['release_date'] = date("Y-m-d", $album_data['release_date']);
		$track = new TrackModel();
		$album_data['tracks'] = $track->get_tracks($param['id']);
		exit($this->render($album_data));

	}
	public function find_albumAction($param) {
		if(!isset($param['name'])) {
			header('Location: '.BASE_URI.'?controller=Error&action=invalidArgument');
		}
		$album = new AlbumModel();
		$album_research = $album->find_album($param['name']);
		exit($this->render($album_research));
	}

	public function get_random_albumAction() {
		$album = new AlbumModel();
		$number_albums = $album->get_album_count_total();
		$in = "";
		for ($i=0; $i <10 ; $i++) { 
			$in.=rand(1,$number_albums['total']).',';
		}
		$in=substr($in, 0, -1);
		$album_list = $album->get_albums_rand($in);
		exit($this->render($album_list));
	}
}

?>