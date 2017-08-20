<?php

@shell_exec("sudo gpio export 23 out");
@shell_exec("sudo gpio -g write 23 0");

$sleep = 30;
sleep($sleep);

include 'db.php';

init();

while (true) {
	sleep(1);
	$sql = "SELECT * FROM tbl_settings LIMIT 1;";
	$result = mysqli_query($db, $sql);
	if ($debug) {
		echo mysqli_error($db) . "\n";
	}

	while ($row = mysqli_fetch_object($result)) {
		$runforever = $row->runforever == 1;
		$startnewintervall = $row->startnewintervall == 1;
		$stopnow = $row->stopnow == 1;
		$feuchtsens_use = $row->feuchtsens_use == 1;
		$tempsens_use = $row->tempsens_use == 1;
		$time_to_pause = intval($row->time_to_pause);
		$time_to_run = intval($row->time_to_run);
		$sollfeucht = intval($row->feuchtsens_feucht);
		$solltemp = intval($row->tempsens_temp);
	}

	$feuchtsens_use = false;
	$tempsens_use = false;

	if ($tempsens_use) {
		//check sensor
		$sensor_output = shell_exec("sudo /root/ex/sensor.sh");
		preg_match_all("/Temperature = [0-9]{2}\.[0-9]{2} \*C/", $sensor_output, $matches, PREG_OFFSET_CAPTURE);

		foreach ($matches[0] as $value) {
			$sens_temp = trim(str_replace(array("Temperature =", "*C"), "", $value));
		}

		if ($soll_temp < $sens_temp) {
			if ($debug) {
				echo "solltemp < senstemp; machan\n";
			}
			machan();
		} else {
			if ($debug) {
				echo "solltemp >= senstemp; machaus\n";
			}
			machaus();
		}
		continue;
	}

	if ($feuchtsens_use) {
		//check sensor
		$sensor_output = shell_exec("sudo /root/sh/sensor.sh");
		preg_match_all("/Humidity = [0-9]{2}\.[0-9]{2} %/", $sensor_output, $matches, PREG_OFFSET_CAPTURE);

		foreach ($matches[0] as $value) {
			$sens_feucht = trim(str_replace(array("Humidity =", "%"), "", $value));
		}

		$sql = "UPDATE tbl_settings SET runned='0';";
		mysqli_query($db, $sql);
		if ($debug) {
			echo mysqli_error($db) . "\n";
		}

		if ($soll_feucht < $sens_feucht) {
			if ($debug) {
				echo "sollfeucht < sensfeucht; machan\n";
			}
			machan();
		} else {
			if ($debug) {
				echo "sollfeucht >= sensfeucht; machaus\n";
			}
			machaus();
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
