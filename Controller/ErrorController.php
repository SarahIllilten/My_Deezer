<?php

class ErrorController extends Controller {

	public function mainAction() {
		$error = ['error_message' => 'Invalid request.', "results" => [], "status" => "INVALID_REQUEST"];
		exit(json_encode($error, JSON_FORCE_OBJECT | JSON_PRETTY_PRINT));
	}

	public function invalidArgumentAction() {
		$error = ['error_message' => 'Invalid argument(s).', "results" => [], "status" => "INVALID_ARG"];
		exit(json_encode($error, JSON_FORCE_OBJECT | JSON_PRETTY_PRINT));
	}
}

?>