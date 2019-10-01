<?php

require_once 'Model'.DIRECTORY_SEPARATOR.'AlbumModel.php';
require_once 'Model'.DIRECTORY_SEPARATOR.'ArtistModel.php';

class ArtistsController extends Controller {

	public function get_artists_listAction() {
		$artist = new ArtistModel();
		$artist_list = $artist->get_artists();
		exit($this->render($artist_list));
	}

	public function get_artistAction($param) {
		if(!isset($param['id'])) {
			header('Location: '.BASE_URI.'?controller=Error&action=invalidArgument');
		}
		$artist = new ArtistModel($param['id']);
		$artist_data = $artist->get_artist_data();
		$album = new AlbumModel();
		$artist_data['albums'] = $album->get_albums_artist($param['id']);
		foreach ($artist_data['albums'] as $key => $value) {
			$artist_data['albums'][$key]['release_date'] = date("Y-m-d", $artist_data['albums'][$key]['release_date']);
		}
		exit($this->render($artist_data));

	}
	public function find_artistAction($param) {
		if(!isset($param['name'])) {
			header('Location: '.BASE_URI.'?controller=Error&action=invalidArgument');
		}
		$artist = new ArtistModel();
		$artist_research = $artist->find_artist($param['name']);
		exit($this->render($artist_research));
	}
}