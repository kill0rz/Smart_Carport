<?php
error_reporting(E_ALL);
include 'db.php';

$file_is_playing = '';
$nowplaying = '';
$playlist = '';

if (isset($_GET['skip']) && trim($_GET['skip']) == "track") {
	$tmp = shell_exec("sudo killall mpg123");
}

if (isset($_FILES['mp3file'])) {
	$time = time();
	$basename = "/tmp/mp3files/" . $time . ".mp3";
	echo shell_exec("touch " . $basename);
	shell_exec("chmod 0777 " . $basename);
	if (move_uploaded_file($_FILES['mp3file']['tmp_name'], $basename)) {
		$sql = "INSERT INTO tbl_queue (filepath, realname) VALUES ('" . $basename . "','" . mysqli_real_escape_string($db, $_FILES['mp3file']['name']) . "');";
		mysqli_query($db, $sql);

		$file_is_playing = "<font color='green'>Datei " . htmlentities($_FILES['mp3file']['name']) . " erfolgreich zur Warteschlange hinzugef&uuml;gt.</font><br /><br />\n";
		$file_is_playing = "<div class='alert alert-success'> <a href='#' class='close' data-dismiss='alert'>&times;</a> Datei <b>" . htmlentities($_FILES['mp3file']['name']) . "</b> erfolgreich zur Warteschlange hinzugef&uuml;gt.</div> <br /><br />\n";
	} else {
		$file_is_playing = "<div class='alert alert-danger'> <a href='#' class='close' data-dismiss='alert'>&times;</a> Fehler beim Upload!</div> <br /><br />\n";
	}
}
sleep(1);

$sql = "SELECT * FROM tbl_queue WHERE nowplaying='1' LIMIT 1;";
$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_object($result)) {
		$nowplaying = "<h2>Gerade l&auml;uft:</h2> ";
		$nowplaying .= "<div class='alert alert-warning'> <b>" . $row->ID . "</b>| " . htmlentities($row->realname) . "</div> <br /><br />\n";
	}
	$nowplaying .= "<br /><br />\n";
}

$sql = "SELECT * FROM tbl_queue WHERE nowplaying='0';";
$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0) {
	$playlist = "<h2>Playlist:</h2>";
	while ($row = mysqli_fetch_object($result)) {
		$playlist .= "<b>" . $row->ID . "</b>| " . htmlentities($row->realname) . "<br />\n";
	}
	$playlist .= "<br /><br />\n";
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Music On Pi</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel=stylesheet href="../bootstrap.min.css">
</head>
<body>
	<div class="container">
		<?php echo $file_is_playing; ?>
		<?php echo $nowplaying; ?>
		<?php echo $playlist; ?>
		<div>
			<h1>Datei hinzuf&uuml;gen</h1>
			<form action="./index.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
				<input class="form-control" type="file" name="mp3file" value="" placeholder="deine MP3" accept="audio/mpeg,audio/mp3" /><br />
				<input class="form-control" type="submit" name="play" value="Play!">
			</form>
		</div>
		<a href="./?index.php"><h1>Reload</h1></a>
		<a href="./?skip=track"><h1>Skip Track</h1></a>
	</div>
</body>
</html>
