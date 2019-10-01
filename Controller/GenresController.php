<?php

require_once 'Model'.DIRECTORY_SEPARATOR.'GenreModel.php';
require_once 'Model'.DIRECTORY_SEPARATOR.'AlbumModel.php';


class GenresController extends Controller {

	public function get_genres_listAction() {
		$genre = new GenreModel();
		$genre_list = $genre->get_genres();
		exit($this->render($genre_list));
	}

	public function get_genreAction($param) {
		if(!isset($param['id'])) {
			header('Location: '.BASE_URI.'?controller=Error&action=invalidArgument');
		}
		$genre = new GenreModel($param['id']);
		$genre_data = $genre->get_genre_data();
		$album = new AlbumModel();
		$genre_data['albums'] = $album->get_albums_genre($param['id']);
		exit($this->render($genre_data));

	}
	public function find_genreAction($param) {
		if(!isset($param['name'])) {
			header('Location: '.BASE_URI.'?controller=Error&action=invalidArgument');
		}
		$genre = new GenreModel();
		$genre_research = $genre->find_genre($param['name']);
		exit($this->render($genre_research));
	}
}

?>