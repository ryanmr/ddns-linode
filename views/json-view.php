<?php if (!defined('DD_VIEWS')) {exit(-1);} ?>
<?php
	echo json_encode(array('ip' => $ip, 'hostname' => $hostname));
?>