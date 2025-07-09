<?php
declare(strict_types=1);

$init = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'init.php';
if (!is_file($init)) {
	fwrite(STDERR, 'Config unavailable!');
	exit(1);
}
include $init;

$response = $evoluted::getPoints();
if (is_numeric($response)) {
	$publish::success('Cumulative Points: '.$response, 'CARD POINTS | ~ Script 2');
}

$publish::error('Program failure', 'Unable to get card points');