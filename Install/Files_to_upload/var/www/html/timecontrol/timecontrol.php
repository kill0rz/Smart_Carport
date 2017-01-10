<?php

function nextYear($yearindex) {
	global $month_name, $month_days;
	if ($month_name == "Dec" && $month_days == 31) {
		return $yearindex;
	} else {
		return $yearindex++;
	}
}

function nextIndex($index, $mode = '') {
	global $month_days;
	switch ($mode) {
		case 'month':
			$max = 12;
			break;
		case 'boots':
			$max = 12;
			break;
		case 'day':
			$max = $month_days;
			break;
		default:
			$max = 12;
			break;
	}
	$index++;
	if ($index > $max) {
		return 1;
	} else {
		return $index;
	}
}

$boots = array(
	1 => 'Mo1',
	2 => 'Mo2',
	3 => 'Di1',
	4 => 'Di2',
	5 => 'Mi1',
	6 => 'Mi2',
	7 => 'Do1',
	8 => 'Do2',
	9 => 'Fr1',
	10 => 'Fr2',
	11 => 'Sa',
	12 => 'So',
);

$months_days = array(
	1 => 31,
	2 => 30,
	3 => 31,
	4 => 30,
	5 => 31,
	6 => 30,
	7 => 31,
	8 => 31,
	9 => 30,
	10 => 31,
	11 => 30,
	12 => 31,
);

$months_names = array(
	1 => "Jan",
	2 => "Feb",
	3 => "Mar",
	4 => "Apr",
	5 => "May",
	6 => "Jun",
	7 => "Jul",
	8 => "Aug",
	9 => "Sep",
	10 => "Oct",
	11 => "Nov",
	12 => "Dec",
);

$bootsindex = file_get_contents("timecontrol_ticks.data");
$dayindex = file_get_contents("timecontrol_days.data");
$monthindex = file_get_contents("timecontrol_months.data");
$yearindex = file_get_contents("timecontrol_years.data");

$month_days = $months_days[$monthindex];
$month_name = $months_names[$monthindex];

switch ($bootsindex) {
	case 1:
		$time = "04:00:00 UTC+1";
		$day = "Mon";
		break;
	case 2:
		$time = "16:00:00 UTC+1";
		$day = "Mon";
		break;
	case 3:
		$time = "04:00:00 UTC+1";
		$day = "Tue";
		break;
	case 4:
		$time = "16:00:00 UTC+1";
		$day = "Tue";
		break;
	case 5:
		$time = "04:00:00 UTC+1";
		$day = "Wed";
		break;
	case 6:
		$time = "16:00:00 UTC+1";
		$day = "Wed";
		break;
	case 7:
		$time = "04:00:00 UTC+1";
		$day = "Thu";
		break;
	case 8:
		$time = "16:00:00 UTC+1";
		$day = "Thu";
		break;
	case 9:
		$time = "04:00:00 UTC+1";
		$day = "Fri";
		break;
	case 10:
		$time = "16:00:00 UTC+1";
		$day = "Fri";
		break;
	case 11:
		$time = "07:00:00 UTC+1";
		$day = "Sat";
		break;
	case 12:
		$time = "09:00:00 UTC+1";
		$day = "Sun";
		break;
	default:
		exit();
		break;
}

shell_exec("sudo date -s \"{$day} {$month_name} {$dayindex} {$time} {$yearindex}\"");

if (in_array($bootsindex, array(2, 4, 6, 8, 10, 11, 12))) {
	$dayindex = nextIndex($dayindex, "day");
}

if ($dayindex == 1) {
	$nextMonth = nextIndex($monthindex, "month");
} else {
	$nextMonth = $monthindex;
}

file_put_contents("timecontrol_days.data", $dayindex);
file_put_contents("timecontrol_months.data", $nextMonth);
file_put_contents("timecontrol_years.data", nextYear($yearindex));
file_put_contents("timecontrol_ticks.data", nextIndex($bootsindex, "boots"));
