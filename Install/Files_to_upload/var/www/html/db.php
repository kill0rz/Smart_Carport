<?php

error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
$debug = true;
$runned = 0;
$paused = 0;

$mysql_server = "localhost";
$mysql_user = "root";
$mysql_password = "a";
$mysql_db = "pi";
$db = mysqli_connect($mysql_server, $mysql_user, $mysql_password, $mysql_db);
if (mysqli_errno($db)) {
	echo "databse error\n";
	exit();
}

function machan() {
	global $db, $debug;
	@shell_exec("sudo gpio -g write 23 1");
	$paused = 0;
	$sql = "UPDATE tbl_settings SET should_be_running=1;";
	mysqli_query($db, $sql);
	if ($debug) {
		echo mysqli_error($db);
	}
}

function machaus() {
	global $db, $debug;
	@shell_exec("sudo gpio -g write 23 0");
	$runned = 0;
	$sql = "UPDATE tbl_settings SET should_be_running=0;";
	mysqli_query($db, $sql);
	if ($debug) {
		echo mysqli_error($db);
	}
}

function init() {
	global $db, $debug;
	@shell_exec("sudo gpio -g write 23 0");
	$sql = "UPDATE tbl_settings SET startnewintervall=1;";
	mysqli_query($db, $sql);

	if ($debug) {
		echo mysqli_error($db);
	}

	$sql = "UPDATE tbl_settings SET runned='0';";
	mysqli_query($db, $sql);
	if ($debug) {
		echo mysqli_error($db);
	}
	$runned = 0;

	$sql = "UPDATE tbl_settings SET paused='0';";
	mysqli_query($db, $sql);
	if ($debug) {
		echo mysqli_error($db);
	}
	$paused = 0;
}
