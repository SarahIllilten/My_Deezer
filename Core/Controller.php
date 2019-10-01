<?php

class Controller {
	
	public function render($data) {
		if(empty($data)) {
			$status = 'ZERO_RESULTS';
		} else {
			$status ='OK';
		}
		$response = ["result" => $data, "status" => $status];
		return json_encode($response, JSON_FORCE_OBJECT | JSON_PRETTY_PRINT);
	}

}
