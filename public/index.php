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

use Dev\Db\UsersTable;
use Inane\Db\Adapter\Adapter;
use Inane\Dumper\Dumper;
use Inane\Stdlib\Options;
use Inane\Cli\{
	Pencil\Colour,
	Cli,
	Pencil
};

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

	$testDBLayer = function(Options $config): void {
		UsersTable::$db = new Adapter($config->get('db'));
		$usersTable = new UsersTable();

		$match1 = $usersTable->search(['group' => 'admin']);
		dd($match1);
		$match2 = $usersTable->search(['group' => 'user']);
		dd($match2);
		$match3 = $usersTable->search(['group' => 'user%']);
		dd($match3);

		$users = $usersTable->fetchAll();
		$user3 = $usersTable->fetch(3);
		$user4 = $usersTable->fetch(4);

		dd([
			'users' => $users,
			'user3' => $user3,
			'user4'=> $user4,
		]);
	};

	// Pick and choose what to run
	$menu = [
		'VSCodiumPatcher' => 'VSCodiumPatcher: update extention gallery',
		'PinCode' => 'PinCode: proof of concept',
		'PackageLibrary' => 'PackageLibrary Manager',
		'TestDBLayer' => 'Test Database Layer',
		'' => 'Exit',
	];

	$choice = Cli::menu($menu, null, 'Please choose the module you want to run', 1);

	match($choice) {
		'PinCode'=> new Dev\Task\PinCode(),
		'VSCodiumPatcher'=> new Dev\Util\VSCodiumPatcher($config->vscodium)->patch(),
		'PackageLibrary'=> \Dev\Package\PackageLibrary::getInstance()->run(),
		'TestDBLayer'=> $testDBLayer($config),
		default => '',
	};
} else {
	$file = 'public' . $_SERVER['REQUEST_URI'];
	// Server existing files in web dir
	if (file_exists($file) && !is_dir($file)) return false;

	\Dev\App\Application::getInstance()->run();
}
