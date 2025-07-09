<?php
declare(strict_types=1);

// Settings for Evoluted
define('DS', DIRECTORY_SEPARATOR);
define('RD', __DIR__ . DS);
$storage = RD . 'storage' . DS;
$autoload = RD . 'vendor' . DS . 'autoload.php';

if (!is_file($autoload)) {
	fwrite(STDERR, 'Autoload unavailable!');
	exit(1);
}

// Initialize
include $autoload;
$publish = new Evoluted\Helper\Publish();
$evoluted = new Evoluted\Evoluted();
$evoluted::setFile($storage);