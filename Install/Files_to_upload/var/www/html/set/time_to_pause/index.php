<?php

include '../../db.php';

if (isset($_GET['value']) && trim($_GET['value']) != '') {
	$sql = "UPDATE tbl_settings SET time_to_pause=" . intval($_GET['value']) . ";";
	mysqli_query($db, $sql);
}

if ($debug) {
	echo mysqli_error($db);
}