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

namespace Dev\App;

/**
 * AppError
 *
 * @version 1.0.0
 */
enum AppError: int {
	case InvalidRoute = 400;

	/**
	 * Get the user-friendly message
	 *
	 * @return string Error Message
	 */
	public function message(): string {
		return match ($this) {
			self::InvalidRoute => 'Invalid Route: not found.',
		};
	}
}
