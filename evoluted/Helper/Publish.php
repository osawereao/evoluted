<?php
declare(strict_types=1);

namespace Evoluted\Helper;

final class Publish
{
	// Displays horizontal character
	private static function hr(string $format, string $character = '-'): void
	{
		$width = exec('tput cols') ?: 60;
		echo "\033[{$format}" . str_repeat($character, (int) $width) . "\033[0m" . PHP_EOL;
	}


	// Displays formatted error message
	public static function error(string $message, string $hint = ''): void
	{
		$title = PHP_EOL . "\033[31mERROR!\033[0m" . PHP_EOL;

		fwrite(STDERR, $title);
		self::hr('31m');

		$error = $message . PHP_EOL;

		if (!empty($hint)) {
			$error .= "\033[3m({$hint})\033[0m\n";
		}

		fwrite(STDERR, $error . PHP_EOL);
		exit(1);
	}


	// Displays formatted success message
	public static function success(string $message, string $title = ''): void
	{
		if (!empty($title)) {
			$title = PHP_EOL . "\033[32m{$title}\033[0m" . PHP_EOL;
			fwrite(STDERR, $title);
		}
		self::hr('32m');

		$success = $message . PHP_EOL;

		fwrite(STDERR, $success . PHP_EOL);
		exit(0);
	}


	// Displays formatted info message
	public static function info(string $message, string $title = ''): void
	{
		if (!empty($title)) {
			$title = PHP_EOL . "\033[34m{$title}\033[0m" . PHP_EOL;
			fwrite(STDERR, $title);
		}
		self::hr('34m');

		$info = $message . PHP_EOL;

		fwrite(STDERR, $info . PHP_EOL);
		exit();
	}


	// Displays json formatted message
	public static function json($data, string $title = ''): void
	{
		$json = Json::encode($data);

		if ($json && Json::validate($json)) {
			$json = self::format($json);
		}

		if (is_string($json)) {
			self::success($json, $title);
		}

		if (is_string($data)) {
			self::info($data);
		}

		self::error('Wrong data type', gettype($json) . ' is not json');
	}


	// Formats data as required in the program
	private static function format(mixed $json, array $keysToInline = ['winning', 'yours']): string
	{
		foreach ($keysToInline as $key) {
			$pattern = sprintf(
				'/("%s"\s*:\s*)\[\s*((?:\d+\s*,\s*)*\d+)\s*\]/m',
				preg_quote($key, '/')
			);

			$json = preg_replace_callback($pattern, function ($matches) {
				$inlineArray = '[' . preg_replace('/\s+/', ' ', trim($matches[2])) . ']';
				return $matches[1] . $inlineArray;
			}, $json);
		}

		return $json;
	}
}