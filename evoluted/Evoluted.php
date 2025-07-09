<?php
declare(strict_types=1);

namespace Evoluted;

use Evoluted\Helper\File;
use Evoluted\Helper\Publish;

final class Evoluted
{
	// Properties
	private static $file;


	// Set default input file
	public static function setFile(string $storage, string $file = 'input.txt'): void
	{
		if (!is_dir($storage)) {
			Publish::error('Storage path unaccessible', $storage);
		}

		$file = $storage . $file;
		File::ensure($file);

		self::$file = $file;
	}


	// Get data from input file
	public static function getData(?string $file = null)
	{
		if (!empty($file)) {
			File::ensure($file);
		} elseif (!empty(self::$file)) {
			$file = self::$file;
		}

		if (empty($file)) {
			Publish::error('Input file required');
		}

		$data = File::lines($file);
		if (!is_array($data) || empty($data)) {
			Publish::error('Data is invalid', $file);
		}

		# prepare data
		$data = self::prepare($data);

		if (empty($data)) {
			Publish::error('Data is invalid or corrupt', 'check input data format');
		}

		return $data;
	}


	// Get cumulative points from file's data
	public static function getPoints(?string $file = null)
	{
		$cards = self::getData($file);
		return self::cumulativePoints($cards);
	}


	// Prepare data with pattern for use
	private static function prepare(array $data): array
	{
		$result = [];
		foreach ($data as $row) {
			if (preg_match('/^Card\s+(\d+):\s+(.+?)\s+\|\s+(.+)$/', $row, $matches)) {
				$card = (int) $matches[1];
				$winning = array_map('intval', preg_split('/\s+/', trim($matches[2])));
				$yours = array_map('intval', preg_split('/\s+/', trim($matches[3])));

				$result[] = [
					'card' => $card,
					'winning' => $winning,
					'yours' => $yours
				];
			}
		}

		return $result;
	}


	// Calculate cumulative points
	private static function cumulativePoints(array $cards): int
	{
		$points = 0;
		if (!empty($cards)) {
			foreach ($cards as $card) {
				$matches = array_intersect($card['winning'], $card['yours']);
				$count = count($matches);

				if ($count > 0) {
					$points += 1 << ($count - 1); // 2^(count - 1)
				}
			}
		}

		return $points;
	}
}