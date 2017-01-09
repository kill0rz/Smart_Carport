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
	echo json_encode($new_row);
	exit();
}