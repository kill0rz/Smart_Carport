<?php

@shell_exec("sudo gpio export 23 out");
@shell_exec("sudo gpio -g write 23 0");

$sleep = 30;
sleep($sleep);

include 'db.php';

init();

while (true) {
	sleep(1);

	$row = file($pi_url . "/get");
	$row = json_decode($row[0]);

	$runforever = $row->runforever == 1;
	$startnewintervall = $row->startnewintervall == 1;
	$stopnow = $row->stopnow == 1;
	$tempfeuchtsens_use = $row->tempfeuchtsens_use == 1;
	$time_to_pause = intval($row->time_to_pause);
	$time_to_run = intval($row->time_to_run);
	$soll_temp = intval($row->soll_temp);
	$soll_feucht = intval($row->soll_feucht);
	$ist_temp = floatval($row->ist_temp);
	$ist_feucht = floatval($row->ist_feucht);

	if ($tempfeuchtsens_use) {
		// doppelte Abfrage, um debug ordentlich handeln zu können
		if ($soll_feucht < $ist_feucht || $soll_temp > $ist_temp) {
			machan();
		} else {
			echo "Tempsonsor zu wenig; machaus\n";
			machaus();
		}

		if ($debug && $soll_temp > $ist_temp) {
			echo "solltemp > senstemp; machan\n";
		}
		if ($debug && $soll_feucht < $ist_feucht) {
			echo "sollfeucht < sensfeucht; machan\n";
		}
		continue;
	}

	if ($startnewintervall) {
		machan();
		if ($debug) {
			echo "machan - neu intervall \n";
		}

		$sql = "UPDATE tbl_settings SET startnewintervall=0;";
		mysqli_query($db, $sql);
		$runned = 0;
		if ($debug) {
			echo mysqli_error($db) . "\n";
		}

		$sql = "UPDATE tbl_settings SET runned='0';";
		mysqli_query($db, $sql);
		if ($debug) {
			echo mysqli_error($db) . "\n";
		}

		$sql = "UPDATE tbl_settings SET runforever='0';";
		mysqli_query($db, $sql);
		if ($debug) {
			echo mysqli_error($db) . "\n";
		}
		continue;
	}

	if ($stopnow) {
		machaus();
		if ($debug) {
			echo "stopnow - machaus\n";
		}
		if ($debug) {
			echo mysqli_error($db) . "\n";
		}

		$sql = "UPDATE tbl_settings SET runned='0';";
		mysqli_query($db, $sql);
		if ($debug) {
			echo mysqli_error($db) . "\n";
		}
		continue;
	}

	if ($runforever) {
		machan();
		if ($debug) {
			echo "runforever - machan\n";
		}
		if ($debug) {
			echo mysqli_error($db) . "\n";
		}

		$sql = "UPDATE tbl_settings SET runned='0';";
		mysqli_query($db, $sql);
		if ($debug) {
			echo mysqli_error($db) . "\n";
		}
		continue;
	}

	if ($runned >= $time_to_run) {
		machaus();
		if ($debug) {
			echo "runned groesser - machaus\nrunned: " . $runned . " - time_to_run: " . $time_to_run . "\n";
		}

		if ($time_to_pause != 0 && $paused >= $time_to_pause) {
			if ($debug) {
				echo "pause endet\n";
			}
			$runned = 0;
			$sql = "UPDATE tbl_settings SET runned='0';";
			mysqli_query($db, $sql);
			if ($debug) {
				echo mysqli_error($db) . "\n";
			}

			$paused = 0;
			$sql = "UPDATE tbl_settings SET paused='0';";
			mysqli_query($db, $sql);
			if ($debug) {
				echo mysqli_error($db) . "\n";
			}

			machan();
		} else {
			$paused += 1;

			if ($debug) {
				echo "continue pause:" . $paused . "\n";
			}

			$sql = "UPDATE tbl_settings SET paused='" . $paused . "';";
			mysqli_query($db, $sql);
			if ($debug) {
				echo mysqli_error($db) . "\n";
			}

			if ($debug) {
				echo "\n\n";
			}
		}
		continue;
	}

	if ($debug) {
		echo "allg - machan\n";
	}

	machan();

	if ($debug) {
		echo "runned: " . $runned . "\n";
	}

	$runned += 1;

	$sql = "UPDATE tbl_settings SET runned='" . $runned . "';";
	mysqli_query($db, $sql);
	if ($debug) {
		echo mysqli_error($db) . "\n";
	}

	if ($debug) {
		echo "\n\n";
	}
}
