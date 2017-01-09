<?php

$mysql_server = "localhost";
$mysql_user = "root";
$mysql_password = "a";
$mysql_db = "pi";
$db = mysqli_connect($mysql_server, $mysql_user, $mysql_password, $mysql_db);
if (mysqli_errno($db)) {
	echo "databse error\n";
	exit();
}
