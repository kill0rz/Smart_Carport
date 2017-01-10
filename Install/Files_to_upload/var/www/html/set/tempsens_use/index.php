<?php

include '../../db.php';

if (isset($_GET['value']) && trim($_GET['value']) != '') {
	if (intval($_GET['value']) == 1) {
		$sql = "UPDATE tbl_settings SET tempsens_use=1; ";
	} else {
		$sql = "UPDATE tbl_settings SET tempsens_use=0;";
	}
	mysqli_query($db, $sql);
	echo mysqli_error($db);
}
