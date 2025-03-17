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

use Inane\Cli\Cli;
use Inane\Cli\Pencil;
use Inane\Cli\Pencil\Colour;
use Inane\Dumper\Dumper;
use Inane\Stdlib\Options;

chdir(dirname(__DIR__));

require 'vendor/autoload.php';

// TODO: PhpRenderer example
// BUG: bug
// HACK: hack
// FIXME: boo

Dumper::setExceptionHandler();

if (Cli::isCli()) {
	// Load & lock configuration data
	$config = new Options(include 'config/app.config.php');
	$files = glob('config/autoload/{{,*.}global,{,*.}local}.php', GLOB_BRACE | GLOB_NOSORT);
	foreach ($files as $file) $config->merge(include $file);
	$config->lock();

	// Welcome to Develop console application
	$pP = new Pencil(Colour::Purple);
	$pP->line('Develop running as console application.' . PHP_EOL);

	// Pick and choose what to run
	$menu = [
		'VSCodiumPatcher' => 'VSCodiumPatcher: update extention gallery',
		'PinCode' => 'PinCode: proof of concept',
		'' => 'Exit',
	];

	$choice = Cli::menu($menu, null, 'Please choose the module you want to run', 1);

	match($choice) {
		'PinCode'=> new Dev\Task\PinCode(),
		'VSCodiumPatcher'=> new Dev\Util\VSCodiumPatcher($config->vscodium)->patch(),
		default => '',
	};
} else {
	$file = 'public' . $_SERVER['REQUEST_URI'];
	// Server existing files in web dir
	if (file_exists($file) && !is_dir($file)) return false;

	\Dev\App\Application::getInstance()->run();
}
