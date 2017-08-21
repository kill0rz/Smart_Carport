<?php

include '../db.php';

$sql = "SELECT * FROM tbl_settings LIMIT 1;";

$result = mysqli_query($db, $sql);
if ($debug) {
	echo mysqli_error($db);
}

while ($row = mysqli_fetch_object($result)) {
	$new_row = $row;
	$new_row->is_running = trim(shell_exec("gpio -g read 23"));
	preg_match_all("/Temp=(.*) Humidity=(.*)/", trim(shell_exec("sudo /root/sh/sensor.sh")), $matches);
	$new_row->ist_temp = (isset($matches[1][0])) ? trim(str_replace("*", "", $matches[1][0])) : "nAn";
	$new_row->ist_feucht = (isset($matches[1][0])) ? trim(str_replace("%", "", $matches[2][0])) : "nAn";
	echo json_encode($new_row);
	exit();
}