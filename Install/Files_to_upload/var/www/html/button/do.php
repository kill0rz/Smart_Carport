<?php

@shell_exec("sudo gpio export 7 in");
@shell_exec("sudo gpio export 25 out");
@shell_exec("sudo gpio -g write 25 0");
// @shell_exec("amixer cset numid=3 1");

while (true) {
	// 0,1s
	usleep(100000);
	$port = @shell_exec("sudo gpio -g read 7");
	echo "||" . $port . "||\n";
	echo "hier kommt irgendwie immer ne 1, aber warum?!\n";

	if (trim($port) == 0) {
		//button gedrückt, feuer!

		//relais an
		@shell_exec("sudo gpio -g write 25 1");
		//1s warten
		sleep(2);
		//ton ab
		@shell_exec("sudo mpg123 deutschland.mp3");
		//relais aus
		@shell_exec("sudo gpio -g write 25 0");
	}
	$port = 0;
}
