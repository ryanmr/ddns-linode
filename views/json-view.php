<?php if (!defined('DD_VIEWS')) {exit(-1);} ?>
<?php
	echo json_encode(array(
		'ip' => $ip,
		'hostname' => $hostname,
		'last_update' => $last_update,
		'last_update_human' => date('l, F jS, Y; g:i A', $last_update),
		'updates' => $updates
	));
?>