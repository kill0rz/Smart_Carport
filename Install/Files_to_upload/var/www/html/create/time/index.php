<?php

$output = '';
exec('crontab -l', $output);
$output = implode("\n", $output);
file_put_contents('/tmp/crontab.txt', $output . '* * * * * NEW_CRON' . "\n" . PHP_EOL);
echo exec('crontab /tmp/crontab.txt');