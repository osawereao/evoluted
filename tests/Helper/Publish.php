<?php
namespace Tests\Helper;

use Exception;

class PublishException extends Exception
{
}

final class Publish
{
	public static function error(string $message, string $hint = ''): void
	{
		throw new PublishException($message . ($hint ? " ({$hint})" : ''));
	}

	public static function success(string $message, string $title = ''): void
	{
	}

	public static function info(string $message, string $title = ''): void
	{
	}

	public static function json($data, string $title = ''): void
	{
	}
}
