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

namespace Dev\Kaka;

/**
 * Kaka
 *
 * This is where I a bunch of crap I'm experimenting with.
 *
 * @package Develop\Kaka
 */
class Kaka {
    /**
     * Kaka instance for singleton
     *
     * @var Kaka
     */
    private static Kaka $instance;

    /**
     * Private constructor for singleton
     *
     * @return void
     */
    private function __construct() {
        // Do nothing
    }

    /**
	 * Gets the instance of Kaka
	 *
	 * @return \Dev\Kaka\Kaka The instance of Kaka
	 */
	public static function getInstance(): static {
		if (!isset(self::$instance))
			self::$instance = new static();

		return self::$instance;
	}
}
