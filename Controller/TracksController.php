<?php

require_once 'Model'.DIRECTORY_SEPARATOR.'TrackModel.php';

class TracksController extends Controller {

	public function get_tracks_listAction($param) {
		if(!isset($param['album'])) {
			// header('Location: '.BASE_URI.'?controller=Error&action=invalidArgument');
		}
		$track = new trackModel();
		$track_list = $track->get_tracks($param['album']);
		exit($this->render($track_list));
	}

	public function get_trackAction($param) {
		if(!isset($param['id'])) {
			header('Location: '.BASE_URI.'?controller=Error&action=invalidArgument');
		}
		$track = new trackModel($param['id']);
		$track_data = $track->get_track_data();
		exit($this->render($track_data));

	}
	public function find_trackAction($param) {
		if(!isset($param['name'])) {
			header('Location: '.BASE_URI.'?controller=Error&action=invalidArgument');
		}
		$track = new trackModel();
		$track_research = $track->find_track($param['name']);
		exit($this->render($track_research));
	}

	public function find_track_albumAction($param) {
		if(!isset($param['id'])) {
			header('Location: '.BASE_URI.'?controller=Error&action=invalidArgument');
		}
		$track = new trackModel();
		$track_research = $track->find_track_album($param['id']);
		exit($this->render($track_research));
	}
}

?>