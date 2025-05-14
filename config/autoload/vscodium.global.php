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
	'vscodium'   => [
		'file' => [
			'vscode' => 'C:\Users\Philip\AppData\Local\Programs\Microsoft VS Code\resources\app\product.json',
			'vscodium' => 'C:\Program Files\VSCodium\resources\app\product.json',
		],
		'gallery' => [
			'keyName' => 'extensionsGallery',
		],
		'format' => [
			'file' => new Pencil(Colour::Blue, style: Style::Bold),
			'progress' => new Pencil(Colour::Green),
			'title' => new Pencil(Colour::Purple),
			'error' => new Pencil(Colour::Red),
			'reset' => Pencil::reset(),
		],
	],
];
