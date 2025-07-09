<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Alias Publish to your mock ONLY during tests
class_alias(\Tests\Helper\Publish::class, \Evoluted\Helper\Publish::class);
