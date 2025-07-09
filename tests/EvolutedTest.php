<?php

// Define APP_ENV constant or environment variable before anything else
putenv('APP_ENV=testing');
define('APP_ENV', 'testing');


use Evoluted\Evoluted;
use Tests\Helpers\PublishException;

uses()->group('Evoluted');

beforeEach(function () {
	// Setup a temporary directory for input files
	$this->tmpDir = sys_get_temp_dir() . '/evoluted_tests/';
	if (!is_dir($this->tmpDir)) {
		mkdir($this->tmpDir);
	}
});

afterEach(function () {
	// Cleanup all files created for the tests
	array_map('unlink', glob($this->tmpDir . '*'));
	rmdir($this->tmpDir);
});

test('getData returns prepared data for valid file', function () {
	$content = <<<DATA
Card 1: 3 5 7 | 5 7 9
Card 2: 1 2 3 | 3 4 5
DATA;

	$file = $this->tmpDir . 'input.txt';
	file_put_contents($file, $content);

	Evoluted::setFile($this->tmpDir);

	$data = Evoluted::getData();

	expect($data)->toBeArray()->not()->toBeEmpty();
	expect($data[0])->toMatchArray([
		'card' => 1,
		'winning' => [3, 5, 7],
		'yours' => [5, 7, 9],
	]);
});

test('getData throws on missing storage path', function () {
	$this->expectException(PublishException::class);
	$this->expectExceptionMessage('Storage path unaccessible');

	Evoluted::setFile('/non/existing/path/');
});

test('getData throws when file is empty or invalid', function () {
	$file = $this->tmpDir . 'input.txt'; // Use default filename to align with setFile()

	file_put_contents($file, '');

	Evoluted::setFile($this->tmpDir);

	$this->expectException(PublishException::class);
	$this->expectExceptionMessage('Data is invalid');

	// Call getData without argument to use the file set via setFile()
	Evoluted::getData();
});

test('getPoints returns correct cumulative points', function () {
	$content = <<<DATA
Card 1: 3 5 7 | 5 7 9
Card 2: 1 2 3 | 3 4 5
DATA;

	$file = $this->tmpDir . 'points.txt';
	file_put_contents($file, $content);

	$points = Evoluted::getPoints($file);

	// Calculation:
	// Card 1 matches: 5,7 → count=2 → 2^(2-1)=2 points
	// Card 2 matches: 3 → count=1 → 2^(1-1)=1 point
	// Total = 3 points
	expect($points)->toBe(3);
});


test('prepare filters out invalid lines and processes only matching patterns', function () {
    // Using reflection to test private method prepare()
    $data = [
        'Card 1: 1 2 3 | 4 5 6',
        'Invalid line here',
        'Card 2: 7 8 9 | 10 11 12',
        'Another invalid'
    ];

    $reflector = new ReflectionClass(Evoluted::class);
    $method = $reflector->getMethod('prepare');
    $method->setAccessible(true);

    $result = $method->invoke(null, $data);

    expect($result)->toBeArray();
    expect(count($result))->toBe(2); // Only 2 valid lines processed
    expect($result[0])->toMatchArray([
        'card' => 1,
        'winning' => [1, 2, 3],
        'yours' => [4, 5, 6],
    ]);
});




it('cumulativePoints returns 0 for empty cards array', function () {
    $reflector = new ReflectionClass(Evoluted::class);
    $method = $reflector->getMethod('cumulativePoints');
    $method->setAccessible(true);

    $result = $method->invoke(null, []);

    expect($result)->toBeInt();
    expect($result)->toBe(0);
});
