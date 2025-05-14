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

use Inane\Cli\Pencil;
use Inane\Cli\Pencil\Colour;
use Inane\Cli\Pencil\Style;

return [
	'imagestripper'   => [
		'fileObjects' => false,
		'path' => [
			'download' => 'C:/',
			/**
			 * How to process the rather common `image-1` directory.
			 *
			 * - increment: `image-2`, `image-3`, etc.
			 * - md5: `image-1` is replaced with a hash of the links to try reduce duplicate downloads.
			 * - uniqid: `image-1` number is replaced with a unique ID.
			 */
			'image1Handler' => 'md5',
		],
		'format' => [
			'file' => new Pencil(Colour::Blue, style: Style::Bold),
			'blue' => new Pencil(Colour::Blue),
			'progress' => new Pencil(Colour::Green),
			'title' => new Pencil(Colour::Purple),
			'error' => new Pencil(Colour::Red),
			'white' => new Pencil(Colour::White),
			'reset' => Pencil::reset(),
		],
		'images' => [],
	],
];
