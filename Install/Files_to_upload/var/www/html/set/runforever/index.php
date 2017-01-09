<?php

include '../../db.php';

if (isset($_GET['value']) && trim($_GET['value']) != '') {
	if (intval($_GET['value']) == 1) {
		$sql = "UPDATE tbl_settings SET runforever=1;";
		mysqli_query($db, $sql);
		echo mysqli_error($db);
		$sql = "UPDATE tbl_settings SET stopnow=0;";
		mysqli_query($db, $sql);
	} else {
		$sql = "UPDATE tbl_settings SET runforever=0;";
		mysqli_query($db, $sql);
	}
}