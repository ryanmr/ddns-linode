<?php if (!defined('DD_VIEWS')) {exit(-1);} ?>
<!doctype html>
<html>
<head>
	
	<title><?php echo $hostname; ?></title>


	<style type="text/css">
		body {
			background-color: #ddd;
			color: #222;
			font-size: 1em;
			font-family: Helvetica, Arial, sans-serif;
		}
		.container h1 {
			font-size: 4em;
			text-align: center;
		}
		a, a:link {
			color: #222;
			text-decoration: none;
		}
		a:hover {
			color: #000;
			text-decoration: underline;
		}
	</style>

</head>
<body>

	<div class="container">
		<h1><a href="http://<?php echo $ip; ?>/"><?php echo $ip; ?></a></h1>
	</div>

</body>
</html>