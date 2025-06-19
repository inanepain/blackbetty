<?php

declare(strict_types=1);

return;
$exitAfterIncludes = true;
$pen->red->line(__FILE__);

// ==================================================================
// Test UUIDTool
// Start code here
// ==================================================================

class UUIDTool {

	#region UUID Constants

	/**
	 * When this namespace is specified, the name string is a fully-qualified
	 * domain name
	 *
	 * @link http://tools.ietf.org/html/rfc4122#appendix-C RFC 4122, Appendix C: Some Name Space IDs
	 */
	public const string NAMESPACE_DNS = '6ba7b810-9dad-11d1-80b4-00c04fd430c8';

	/**
	 * When this namespace is specified, the name string is a URL
	 *
	 * @link http://tools.ietf.org/html/rfc4122#appendix-C RFC 4122, Appendix C: Some Name Space IDs
	 */
	public const string NAMESPACE_URL = '6ba7b811-9dad-11d1-80b4-00c04fd430c8';

	/**
	 * When this namespace is specified, the name string is an ISO OID
	 *
	 * @link http://tools.ietf.org/html/rfc4122#appendix-C RFC 4122, Appendix C: Some Name Space IDs
	 */
	public const string NAMESPACE_OID = '6ba7b812-9dad-11d1-80b4-00c04fd430c8';

	/**
	 * When this namespace is specified, the name string is an X.500 DN in DER
	 * or a text output format
	 *
	 * @link http://tools.ietf.org/html/rfc4122#appendix-C RFC 4122, Appendix C: Some Name Space IDs
	 */
	public const string NAMESPACE_X500 = '6ba7b814-9dad-11d1-80b4-00c04fd430c8';

	#endregion UUID Constants

	public static function getVersion(string $uuid): int {
		if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $uuid)) {
			throw new InvalidArgumentException('Invalid UUID format.');
		}

		return (int) substr($uuid, 14, 1);
	}

	#region uuied creators

	public static function v3(string $namespace, string $name): string {
		if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $namespace)) {
			throw new InvalidArgumentException('Invalid namespace UUID format.');
		}

		$n_hex      = str_replace(['-', '{', '}'], '', $namespace); // Getting hexadecimal components of namespace
		$binary_str = ''; // Binary Value

		//Namespace UUID to bits conversion
		for ($i = 0; $i < strlen($n_hex); $i += 2) {
			$binary_str .= chr(hexdec($n_hex[$i] . $n_hex[$i + 1]));
		}

		//hash value
		$hashing = md5($binary_str . $name);

		return sprintf(
			'%08s-%04s-%04x-%04x-%12s',
			// 32 bits for the time low
			substr($hashing, 0, 8),
			// 16 bits for the time mid
			substr($hashing, 8, 4),
			// 16 bits for the time hi,
			(hexdec(substr($hashing, 12, 4)) & 0x0fff) | 0x3000,
			// 8 bits and 16 bits for the clk_seq_hi_res,
			// 8 bits for the clk_seq_low,
			(hexdec(substr($hashing, 16, 4)) & 0x3fff) | 0x8000,
			// 48 bits for the node
			substr($hashing, 20, 12),
		);
	}

	public static function v4(?string $data = null): string {
		if ($data) {
			switch (strlen($data)) {
				case 36:
					$data = str_replace('-', '', $data);
				case 32:
					$data = hex2bin($data);
			}

			// if (strlen($data) == 36) $data = str_replace('-','',$data);
			// if (strlen($data) == 32) $data = hex2bin($data);
		}

		// Generate 16 bytes (128 bits) of random data or use the data passed into the function.
		$data = $data ?? random_bytes(16);
		assert(strlen($data) == 16);

		// Set version to 0100
		$data[6] = chr(ord($data[6]) & 0x0f | 0x40);
		// Set bits 6-7 to 10
		$data[8] = chr(ord($data[8]) & 0x3f | 0x80);

		// Output the 36 character UUID.
		return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
	}

	public static function v5(string $namespace, string $name): string {
		if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $namespace)) {
			throw new InvalidArgumentException('Invalid namespace UUID format.');
		}

		$namespace = str_replace('-', '', $namespace);
		$hash      = sha1(hex2bin($namespace) . $name);

		return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split($hash, 4));
	}

	public static function v7(?int $milliseconds = null): string {
		static $last_timestamp = 0;

		if ($milliseconds && strlen((string) $milliseconds) > 13) {
			$milliseconds = intval(substr((string) $milliseconds, 0, 13));
		} elseif ($milliseconds && strlen((string) $milliseconds) < 13) {
			$milliseconds = intval(str_pad((string) $milliseconds, 13, '0', \STR_PAD_RIGHT));
		}

		$unixts_ms = $milliseconds ?: intval(microtime(true) * 1000);
		if ($last_timestamp >= $unixts_ms) {
			$unixts_ms = $last_timestamp + 1;
		}

		$last_timestamp = $unixts_ms;
		$data           = random_bytes(10);
		$data[0]        = chr((ord($data[0]) & 0x0f) | 0x70); // set version
		$data[2]        = chr((ord($data[2]) & 0x3f) | 0x80); // set variant

		return vsprintf(
			'%s%s-%s-%s-%s-%s%s%s',
			str_split(
				str_pad(dechex($unixts_ms), 12, '0', \STR_PAD_LEFT) . bin2hex($data),
				4,
			),
		);
	}

	#endregion uuied creators
}

$id4 = UUIDTool::v4(); // Example usage
echo UUIDTool::getVersion($id4) . ': ' . $id4 . PHP_EOL;
$id5 = UUIDTool::v5('33d75eb7-e3dd-475d-8fd6-0bc3b4ce10d0', 'cathedral.co.za'); // Example usage
echo UUIDTool::getVersion($id5) . ': ' . $id5 . PHP_EOL;
$id7 = UUIDTool::v7(); // Example usage
echo UUIDTool::getVersion($id7) . ': ' . $id7 . PHP_EOL;

// 550e8400-e29b-41d4-a716-446655440000
// 9bb65a81-36ca-48b8-a3a9-c55cfa148bce
// 4e6039cb-998a-0d28-9eda-a72bab1ace10
// 019680be-b928-7dcd-b855-d2020948bd8f

// 33d75eb7-e3dd-475d-8fd6-0bc3b4ce10d0
// 4e6039cb-998a-0d28-9eda-a72bab1ace10
// 019680be-d724-746b-8e9e-752a13c521dd

// df858bbf-45d2-4172-97bb-52f74f48c44d
// 5ff58d03-64d3-fd5a-045b-766f808c9b46
// 019680bf-4da4-7268-89a4-fd29e94eb0cd
