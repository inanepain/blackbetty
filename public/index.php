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

use Inane\Dumper\Dumper;
use Inane\Stdlib\Options;

chdir(dirname(__DIR__));

require 'vendor/autoload.php';

// TODO: PhpRenderer example
// BUG: bug
// HACK: hack
// FIXME: boo

Dumper::setExceptionHandler();

if (\Inane\Cli\Cli::isCli()) {
	$config = new Options(include 'config/app.config.php');
	$files = glob('config/autoload/{{,*.}global,{,*.}local}.php', GLOB_BRACE | GLOB_NOSORT);
	foreach ($files as $file) $config->merge(include $file);
	$config->lock();

	if ($config->cli->run == 'PinCode')
		$pc = new Dev\Task\PinCode();
	elseif ($config->cli->run == 'VSCodiumPatcher') {
		$vscodiumPatcher = new Dev\Util\VSCodiumPatcher($config->vscodium);
		$vscodiumPatcher->patch();
	}
} else {
	$file = 'public' . $_SERVER['REQUEST_URI'];
	// Server existing files in web dir
	if (file_exists($file) && !is_dir($file)) return false;

	\Dev\App\Application::getInstance()->run();
}
