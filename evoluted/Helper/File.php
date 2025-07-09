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
}