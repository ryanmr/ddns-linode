<?php

class DynamicDNS_DataStore {

	public $config;
	public $data;

	public function __construct() {
		try {
			$this->load();
		} catch (Exception $e) {
			Helper::feedback(array('code' => 500, 'could not handle config/data files'));
		}
	}

	public function load() {
		$this->config = json_decode(file_get_contents(DD_CONFIG));
		$this->data = json_decode(file_get_contents(DD_DATA));
	}

	public function save() {
		file_put_contents(DD_DATA, json_encode($this->data));
	}

}