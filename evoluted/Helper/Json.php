<?php
declare(strict_types=1);

namespace Evoluted\Helper;

final class Json
{
	// Check if value is valid json
	public static function validate(mixed $var): bool
	{
		if (!is_string($var) || trim($var) === '' || is_null($var)) {
			return false;
		}

		$decoded = json_decode($var, true);
		return json_last_error() === JSON_ERROR_NONE && is_array($decoded);
	}


	// Creates a json encoded string, returns it or returns null
	public static function encode(mixed $data): ?string
	{
		if (empty($data)) {
			return null;
		}

		if (is_string($data)) {
			$data = json_decode($data, true);
			if (json_last_error() !== JSON_ERROR_NONE) {
				return null;
			}
		}

		$json = @json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

		if ($json === false || json_last_error() !== JSON_ERROR_NONE) {
			return null;
		}

		return $json;
	}
}