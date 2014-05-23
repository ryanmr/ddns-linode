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

		h1.ip {
			font-size: 4em;
			text-align: center;
		}

		.hidden-react {
			height: 400px;
			width: 90%;
			max-width: 500px;
			margin: 0 auto;
		}
		.hidden-react .details {
			display: none;
		}
		.hidden-react:hover .details {
			display: block;
		}

		.details ul {
			list-style: none;
		}
		.details ul li {
			margin-bottom: 1em;
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
		<h1 class="ip"><a href="http://<?php echo $ip; ?>/"><?php echo $ip; ?></a></h1>
	
		<div class="hidden-react">
			<div class="details">

				<ul>
					<li><strong>Hostname</strong>: <?php echo $hostname; ?></li>
					<li><strong>Last Ping (Human)</strong>: <?php echo date('l, F jS, Y; g:i A', $last_ping); ?></li>					
					<li><strong>Last Update (Human)</strong>: <?php echo date('l, F jS, Y; g:i A', $last_update); ?></li>
					<li><strong>Updates</strong>: <?php echo $updates; ?></li>
				</ul>

			</div>
		</div>

	</div>

</body>
</html>