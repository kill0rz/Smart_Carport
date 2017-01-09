<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel=stylesheet href="./bootstrap.min.css">
	<title>Force Reboot</title>
</head>
<body>
	<div class="container">
	<div class="row">
<?php

if (isset($_GET['doreboot']) && trim($_GET['doreboot']) == "true") {
	$tickfile = "./timecontrol/timecontrol_ticks.data";
	$ticks = trim(file_get_contents($tickfile));
	file_put_contents($tickfile, $ticks - 1);
	echo "System is going down for reboot now...";
	shell_exec("sudo killall mpg123");
	shell_exec("sudo reboot");
}

?>
			<h1>Wirklich neustarten? (<a href="./forcereboot.php?doreboot=true">ja(!)</a>/<a href="./index.php">nein</a>)</h1>
		</div>
	</div>
</body>
</html>
