<?php

error_reporting(E_ALL);

include 'db.php';

$pi_url = "http://192.168.1.31";
$bildurl = $pi_url;
$bildaus = "/schalter_aus.jpg";
$bildan = "/schalter_an.jpg";

if (isset($_POST['action']) && trim($_POST['action']) != '') {
	switch ($_POST['action']) {
		case 'stopnow':
			file($pi_url . "/set/stopnow/?value=1");
			break;

		case 'runforever':
			file($pi_url . "/set/runforever/?value=1");
			break;

		case 'startnewintervall':
			file($pi_url . "/set/startnewintervall/?value=1");
			break;

		case 'tempsens_use':
			file($pi_url . "/set/tempsens_use/?value=1");
			break;

		case 'feuchtsens_use':
			file($pi_url . "/set/feuchtsens_use/?value=1");
			break;
	}
}

if (isset($_POST['startnewintervalltime']) && trim($_POST['startnewintervalltime']) != '') {
	$newtime = intval($_POST['startnewintervalltime']);
	file($pi_url . "/set/time_to_run/?value=" . $newtime);
}

if (isset($_POST['time_to_pause']) && trim($_POST['time_to_pause']) != '') {
	$newtime = intval($_POST['time_to_pause']);
	file($pi_url . "/set/time_to_pause/?value=" . $newtime);
}

sleep(1);

$werte = file($pi_url . "/get");
$werte = json_decode($werte[0]);

if ($werte->stopnow == 1) {
	$stopnow_pic = $bildurl . $bildan;
} else {
	$stopnow_pic = $bildurl . $bildaus;
}

if ($werte->runforever == 1) {
	$runforever_pic = $bildurl . $bildan;
} else {
	$runforever_pic = $bildurl . $bildaus;
}

if ($werte->tempsens_use == 1) {
	$tempsens_pic = $bildurl . $bildan;
} else {
	$tempsens_pic = $bildurl . $bildaus;
}

if ($werte->is_running == 1 && $werte->runforever == 0 && $werte->stopnow == 0) {
	$startnewintervall_pic = $bildurl . $bildan;
} else {
	$startnewintervall_pic = $bildurl . $bildaus;
}

?>
	<!DOCTYPE html>
	<html>

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel=stylesheet href="./bootstrap.min.css">
		<title>ZSH Garage 84</title>
		<script>
		var i = <?php echo $werte->runned; ?>;
		var j = <?php echo $werte->time_to_run; ?>;
		<?php
if ($startnewintervall_pic == $bildurl . $bildan) {
	?>

		setInterval(function() {
			if (i <= j) {
				document.getElementById('time_run_anzeige').innerHTML = i++;
			}
		}, 1000)

		<?php
}
?>
		</script>
		<style type="text/css">
		.link {
			background-color: lightgrey;
			outline: 0.1em solid green;
		}

		.rightfloat {
			float: right;
		}
		</style>
	</head>

	<body>
		<div class="container">
			<div class="link">
				<br />
				<form action="./zsh.php" method="post" accept-charset="utf-8">
					<input type="hidden" name="action" value="stopnow">
					<button class="btn" type="submit">Immer aus</button>
					<img class="link" src="<?php echo $stopnow_pic; ?>" alt="stopnowpic">
				</form>
				<br />
			</div>
			<div class="link">
				<br />
				<form action="./zsh.php" method="post" accept-charset="utf-8">
					<input type="hidden" name="action" value="runforever">
					<button class="btn" type="submit">Immer an</button>
					<img class="link" src="<?php echo $runforever_pic; ?>" alt="runforever_pic">
				</form>
				<br />
			</div>
			<div class="link">
				<br />
				<form action="./zsh.php" method="post" accept-charset="utf-8">
					<input type="hidden" name="action" value="startnewintervall">
					<button class="btn" type="submit">Starte neues Intervall</button>
					<img class="link" src="<?php echo $startnewintervall_pic; ?>" alt="startnewintervall_pic">
				</form>
				<br />
			</div>
			<form action="/zsh.php" method="post" accept-charset="utf-8">
				<input type="number" name="startnewintervalltime" value="<?php echo $werte->time_to_run; ?>" min="1" placeholder="3600">
				<input type="submit" name="submitted" value="Timer speichern">
			</form>
			<br />
			<br />
			<form action="/zsh.php" method="post" accept-charset="utf-8">
				<input type="number" name="time_to_pause" value="<?php echo $werte->time_to_pause; ?>" min="0" placeholder="3600">
				<input type="submit" name="submitted" value="Pause speichern">
			</form>
			<br />
			<br />
			<div class="link">
				<br />
				<form action="./zsh.php" method="post" accept-charset="utf-8">
					<input type="hidden" name="action" value="tempsens_use">
					<button class="btn" type="submit" disabled>Aktiviere Temperatursensor</button>
					<img class="link" src="<?php echo $tempsens_pic; ?>" alt="tempsens_pic">
				</form>
				<br />
			</div>
			<form action="/zsh.php" method="post" accept-charset="utf-8">
				<input type="number" name="tempsens_temp" value="<?php echo $werte->tempsens_temp; ?>" min="1" placeholder="20" disabled>
				<input type="submit" name="submitted" value="Temperatur speichern" disabled>
			</form>
			<br />
			<br />
			<form action="/zsh.php" method="post" accept-charset="utf-8">
				<input type="number" name="feuchtsens_feucht" value="<?php echo $werte->feuchtsens_feucht; ?>" min="0" placeholder="50" disabled>%
				<input type="submit" name="submitted" value="Luftfeuchtigkeit speichern" disabled>
			</form>
			<br />
			<br />
			<div class="link"><a href="./zsh.php">Werte aktualisieren</a>
			</div>
			<div>
				<div id="time_run_anzeige" style="float:left">
					<?php echo $werte->runned; ?>
				</div>
				<div>
					<?php echo "/" . $werte->time_to_run . " Sekunden"; ?>
					<br />
				</div>
			</div>
		</div>
	</body>
</html>