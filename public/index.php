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

use Inane\Stdlib\ArrayObject;
use Inane\Stdlib\Options;

chdir(dirname(__DIR__));

require 'vendor/autoload.php';

// TODO: PhpRenderer example
// BUG: bug
// HACK: hack
// FIXME: boo

if (\Inane\Cli\Cli::isCli()) {
	$pc = new Dev\Task\PinCode();
} else {
	$file = 'public' . $_SERVER['REQUEST_URI'];
	// Server existing files in web dir
	if (file_exists($file) && !is_dir($file)) return false;

	\Dev\App\Application::getInstance()->run();
}