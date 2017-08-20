<?php

include '../../db.php';

if (isset($_GET['value']) && trim($_GET['value']) != '') {
	if (intval($_GET['value']) == 1) {
		$sql = "UPDATE tbl_settings SET tempfeuchtsens_use=1,stopnow=0,runforever=0,startnewintervall=0; ";
	} else {
		$sql = "UPDATE tbl_settings SET tempfeuchtsens_use=0;";
	}
	mysqli_query($db, $sql);
	echo mysqli_error($db);
}
