<?php

include '../../db.php';

if (isset($_GET['value']) && trim($_GET['value']) != '') {
	if (intval($_GET['value']) == 1) {
		$sql = "UPDATE tbl_settings SET runforever=1,tempfeuchtsens_use=0,stopnow=0,startnewintervall=0;";
	} else {
		$sql = "UPDATE tbl_settings SET runforever=0;";
	}
	mysqli_query($db, $sql);
	echo mysqli_error($db);
}