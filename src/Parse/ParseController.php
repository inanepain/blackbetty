<?php

/**
 * Develop
 *
 * Tinkering development environment. Used to play with or try out stuff.
 *
 * PHP version 8.3
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

namespace Dev\Parse;

use Inane\Routing\Route;

class ParseController {
	#[Route(path: '/parse', name: 'parse')]
	public function parse(): array {
		$jp = new JsonObject();
		$jp->jsonString = '{"name": "John", "age": 30, "city": "New York"}';
		dd($jp);
		return [];
	}
}