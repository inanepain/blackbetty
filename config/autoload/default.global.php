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

return [
	'site' => [
		'title' => 'Develop',
	],
	'dumper' => [
		'enabled' => false,
	],
	'developer'   => [
		'name'   => 'Philip Michael Raab',
		'email' => 'peep@cathedral.co.za',
	],
	'cli' => [
		'run' => 'VSCodiumPatcher',
		// 'run' => 'PinCode',
	],
];
