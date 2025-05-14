<?php

/**
 * Develop
 *
 * Tinkering development environment. Used to play with or try out stuff.
 *
 * PHP version 8.4
 *
 * @author Philip Michael Raab<philip@cathedral.co.za>
 * @package Develop\Tinker
 *
 * @license UNLICENSE
 * @license https://unlicense.org/UNLICENSE UNLICENSE
 *
 * @version $Id$
 * $Date$
 */

declare(strict_types=1);

namespace Dev\Task;

use Inane\Cli\Cli;

/**
 * PinCode
 *
 * This **VERY** basic proof of concept.
 *
 * PinCode makes it harder to spy a code by watching people you enter it repeatedly.
 * Not every digit is actually a part of the code. These fluffer digits are used to confuse the spy.
 *
 * Things a real implementation would need (over the PoC):
 * - A pattern to determine which digits are fluffers (something like: ++-+--+)
 */
class PinCode {
	/**
	 * The default pin code
	 *
	 * @var string
	 */
	private string $pinCode = '1470';

	/**
	 * The pin code length
	 *
	 * @var int
	 */
	private int $pinLength = 8;

	protected string $input;

	protected int $attempts = 0;

	private bool $valid = false;

	public function __construct() {
		Cli::line('PinCode');

		do {
			$attempt = $this->requestCode();
		} while (!$this->verifyAttempt($attempt));
	}

	protected function requestCode(): string {
		$this->attempts ++;
		$input = Cli::prompt('Enter PinCode (' . $this->pinLength . ' digits): ');

		if (!is_numeric($input) || strlen($input) !== $this->pinLength) {
			Cli::line('Attempt ' . $this->attempts . '. Invalid PinCode. Must be ' . $this->pinLength . ' digits');

			return $this->requestCode();
		}

		$this->input = $input;

		return $input;
	}

	protected function verifyAttempt(string $input): bool {
		$tmp  = str_split($input);
		$code = '';
		for ($i = 0; $i < count($tmp); $i ++) {
			if ($i % 2 == 0) {
				$code .= $tmp[$i];
			}
		}

		$this->valid = $code === $this->pinCode;

		if ($this->valid) {
			Cli::line('PinCode is valid');
		} else {
			Cli::line('Invalid PinCode');
		}

		return $this->valid;
	}
}