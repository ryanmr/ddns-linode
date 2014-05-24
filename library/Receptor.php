<?php

class DynamicDNS_Receptor {

	private $datastore;
	
	public function __construct() {
		$this->datastore = new DynamicDNS_DataStore(); 
	}

	private function is_request_valid() {
		$hostname = isset($_GET['hostname']) && !empty($_GET['hostname']);
		$token = isset($_GET['token']) && !empty($_GET['token']);

		/*
			Limit hostname to just 64 characters, and
			the token at a maximum if 100; ~12-15 is suggested.
		*/
		if ( strlen($hostname) > 64 || strlen($token) > 100 ) {
			return false;
		}

		return $hostname && $token;
	}

	private function verify_hostname() {
		$hostname = $_GET['hostname'];
		$config = isset( $this->datastore->config->hosts->{$hostname} );
		if ( $config ) {
			if ( isset($this->datastore->data->hosts->{$hostname}) == false ) {
				$obj = new stdClass();
				$obj->{'last_update'} = 0;
				$obj->{'last_ping'} = 0;
				$obj->{'updates'} = 0;
				$obj->{'ip'} = '';
				$this->datastore->data->hosts->{$hostname} = $obj;
			}
			return true;
		}
		return false;
	}

	private function verify_token() {
		$token = $_GET['token'];
		if ( $token == $this->datastore->config->token ) {
			return true;
		}
		return false;
	}

	private function verify_change($hostname) {
		$client_ip = $_SERVER['REMOTE_ADDR'];
		if ( $this->datastore->data->hosts->{$hostname}->{'ip'} == $client_ip ) {
			return false;
		}
		return true;
	}

	public function refresh() {

		if ( !$this->is_request_valid() ) {
			Helper::feedback(array("code" => 400, "status" => "invalid request"));
			return false;
		}
		if ( !$this->verify_token() ) {
			Helper::feedback(array("code" => 401, "status" => "invalid token"));
			return false;
		}
		if ( !$this->verify_hostname() ) {
			Helper::feedback(array("code" => 401, "status" => "invalid hostname"));
			return false;
		}

		$hostname = $_GET['hostname'];

		$config = $this->datastore->config->hosts->{$hostname};
		$data = $this->datastore->data->hosts->{$hostname};

		if ( $this->verify_change($hostname) == false ) {
			$this->ping_data($hostname);
			Helper::feedback(array("code" => 202, "status" => "host not changed"));
			return false;
		}

		$this->update($hostname);

	}

	private function ping_data($hostname) {
		$this->datastore->data->hosts->{$hostname}->{'last_ping'} = time();
		$this->datastore->save();
	}

	private function update_data($hostname, $ip) {
			$this->datastore->data->hosts->{$hostname}->{'ip'} = $ip;
			$this->datastore->data->hosts->{$hostname}->{'updates'} = intval($this->datastore->data->hosts->{$hostname}->{'updates'}) + 1;
			$this->datastore->data->hosts->{$hostname}->{'last_update'} = time();
			$this->datastore->data->hosts->{$hostname}->{'last_ping'} = time();
			$this->datastore->save();
	}

	private function update($hostname) {

		$ip = $_SERVER['REMOTE_ADDR'];
		$ip = htmlentities($ip);

		$url = sprintf("%sapi_key=%s&api_action=domain.resource.update&DomainID=%s&ResourceID=%s&Target=%s", LINODE_API, $this->datastore->config->api_key, $this->datastore->config->hosts->{$hostname}->{'domain_id'}, $this->datastore->config->hosts->{$hostname}->{'resource_id'}, $ip);
		
		if ( $this->datastore->config->hosts->{$hostname}->updatable == true ) {
			$response = file_get_contents($url);
			$response_json = json_decode($response);

			if ( count($response_json->{'ERRORARRAY'}) == 0 ) {
				$this->update_data($hostname, $ip);
				Helper::feedback(array("code" => 201, "status" => "dynamic dns record set successfully"));
				return true;
			}

		} else {
			$this->update_data($hostname, $ip);
			Helper::feedback(array("code" => 201, "status" => "internal dns set successfully"));
			return true;
		}

		Helper::feedback(array("code" => 500, "status" => "dynamic dns failed"));
		return false;

	}

}