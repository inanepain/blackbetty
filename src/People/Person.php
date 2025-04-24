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

namespace Dev\People;

class Person {
	protected(set) string $firstname;
	protected(set) string $surname;

	public string $fullName {
		get {
			return $this->firstname . ' ' . $this->surname;
		}
	}

	public function __construct(string $firstname, string $surname) {
		$this->firstname = $firstname;
		$this->surname   = $surname;
	}
}