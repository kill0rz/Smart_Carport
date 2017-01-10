<?php

@shell_exec("sudo gpio export 25 out");
@shell_exec("sudo gpio -g write 25 0");

sleep(30);

include 'db.php';

function get_queue() {
	global $db;
	$sql = "SELECT * FROM tbl_queue ORDER BY ID";
	$result = mysqli_query($db, $sql);
	return $result;
}

while (true) {
	$result = get_queue();
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_object($result)) {
			$sql2 = "UPDATE tbl_queue SET nowplaying=1 WHERE ID='" . $row->ID . "'";
			mysqli_query($db, $sql2);

			//an, killall, play
			@shell_exec("sudo gpio -g write 25 1");
			sleep(2);
			@shell_exec("sudo killall mpg123");
			if ($debug) {
				echo "Starting to play: " . $row->realname . "\n";
			}
			@shell_exec("sudo mpg123 /tmp/mp3files/" . basename($row->filepath) . " >> /root/sh/m_player.log");
			$sql = "DELETE FROM tbl_queue WHERE ID='" . $row->ID . "';";
			mysqli_query($db, $sql);
			unlink($row->filepath);

			if ($debug) {
				echo "finished and deleted\n";
			}

			//check if anlassen
			$result = get_queue();
			if (mysqli_num_rows($result) < 1) {
				@shell_exec("sudo gpio -g write 25 0");
			}
		}
	}
	sleep(1);
}
