<?php
declare(strict_types=1);

namespace Evoluted\Helper;

final class File
{
	// Checks if file exist and return boolean
	public static function exists(string $filePath): bool
	{
		return is_file($filePath) && is_readable($filePath);
	}


	// Checks if file exist and returns error if not
	public static function ensure(string $path, string $error = ''): void
	{
		if (!self::exists($path)) {
			$error = !empty($error) ? $error : 'File not accessible';
			Publish::error($error, $path);
		}
	}


	// Read file lines, and return the data
	public static function lines(string $filePath): array
	{
		// NOTE: Using this because the file has a SMALL DATASET
		return file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	}
}