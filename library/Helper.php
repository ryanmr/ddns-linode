<?php

class Helper {
	public static function feedback($obj = array()) {
		$obj = array_merge(array(
			"status" => "normal",
			"code" => 200,
			"time" => time()
		), $obj);

		http_response_code($obj['code']);
		echo json_encode($obj);
	}
}