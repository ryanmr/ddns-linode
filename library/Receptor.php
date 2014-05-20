<?php

class DynamicDNS_Receptor {

	private $datastore;

	public function __construct() {
		$this->datastore = new DynamicDNS_DataStore(); 
	}

	private function is_request_valid() {
		$hostname = isset($_GET['hostname']) && !empty($_GET['hostname']);
		$token = isset($_GET['token']) && !empty($_GET['token']);
		return $hostname && $token;
	}

	private function verify_hostname() {
		$hostname = $_GET['hostname'];
		$config = isset( $this->datastore->config->hosts->{$hostname} );
		if ( $config ) {
			if ( isset($this->datastore->data->hosts->{$hostname}) == false ) {
				$obj = new stdClass();
				$obj->{'last_update'} = 0;
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
		// has not changed
		if ( $this->datastore->data->hosts->{$hostname}->{'ip'} == $client_ip ) {
			return false;
		}

		// has changed
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
			Helper::feedback(array("code" => 202, "status" => "host not changed"));
			return false;
		}

		$result = $this->update($hostname);
		if ( $result ) {
			Helper::feedback(array("code" => 201, "status" => "dynamic dns successful"));
		} else {
			Helper::feedback(array("code" => 500, "status" => "dynamic dns failed"));
		}

	}

	private function update($hostname) {

		$ip = $_SERVER['REMOTE_ADDR'];

		$url = sprintf("%sapi_key=%s&api_action=domain.resource.update&DomainID=%s&ResourceID=%s&Target=%s", LINODE_API, $this->datastore->config->api_key, $this->datastore->config->hosts->{$hostname}->{'domain_id'}, $this->datastore->config->hosts->{$hostname}->{'resource_id'}, $ip);
		
		$response = file_get_contents($url);
		$response_json = json_decode($response);

		if ( count($response_json->{'ERRORARRAY'}) == 0 ) {
			$this->datastore->data->hosts->{$hostname}->{'ip'} = $ip;
			$this->datastore->data->hosts->{$hostname}->{'updates'} = $this->datastore->data->hosts->{$hostname}->{'updates'} + 1;
			$this->datastore->data->hosts->{$hostname}->{'last_update'} = time();
			$this->datastore->save();
			return true;
		}

		return false;

	}


}