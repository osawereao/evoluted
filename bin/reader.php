<?php
declare(strict_types=1);

$init = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'init.php';
if (!is_file($init)) {
	fwrite(STDERR, 'Config unavailable!');
	exit(1);
}
include $init;

$response = $evoluted::getData();
if (is_array($response)) {
	$publish::json($response, 'CARD JSON | ~ Script 1');
}

$publish::error('Program failure', 'Unable to get card data');