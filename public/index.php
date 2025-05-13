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
	Arguments,
	Pencil\Colour,
	Cli,
	Pencil
};
use Inane\Dumper\Type;

chdir(dirname(__DIR__));

require 'vendor/autoload.php';

#region console-testing-includes

$pen = new Options([
	'default' => new Pencil(),
	'red' => new Pencil(Colour::Red),
]);

$exitAfterIncludes = false;

if (true) require 'wip/dumper-hide-runkit7.php';
if (!true) require 'wip/dumper-buffer-off.php';
if (!true) require 'wip/cli-playground.php';
if (!true) require 'wip/datatime-test.php';
if (!true) require 'wip/rand.php';
if (!true) require 'wip/letter-usage.php';
if (!true) require 'wip/UUIDTool.php';

if ($exitAfterIncludes) {
	$pen->red->line('Exiting after includes.');
	exit;
}

#endregion console-testing-includes

// TODO: PhpRenderer example
// BUG: bug
// HACK: hack
// FIXME: boo

Dumper::setExceptionHandler();

Dumper::$additionalTypes[] = Type::Todo;

if (Cli::isCli()) {
	// Load & lock configuration data
	$config = new Options(include 'config/app.config.php');
	// $files = glob('config/autoload/{{,*.}global,{,*.}local}.php', GLOB_BRACE | GLOB_NOSORT);
	$files = glob($config->config->glob_pattern, GLOB_BRACE | GLOB_NOSORT);
	foreach ($files as $file) $config->merge(include $file);

	dd(label: 'Make a console app to manage all of this.', options: ['type' => Type::Todo]);
	if (!true) { // The Console App
		$ca = new Dev\Console\App($config);
		$ca->run();
	} else { // The old console handling code: to be moved to a separate file and turned into a class.
		$config->lock();

		// Welcome to Develop console application
		$pP = new Pencil(Colour::Purple);
		$pP->line('Develop running as console application.' . PHP_EOL);

		$testDBLayer = function (Options $config): void {
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
				'user4' => $user4,
			]);
		};

		$args = new Arguments([
			'flags' => [
				'help' => [
					'description' => 'Shows the usage screen with flags and options explained.',
					'aliases' => ['h'],
				],
			],
			'options' => [
				'module' => [
					'description' => 'Module to run => id or name: 1, vscodium, 2, pin, 3, package, 4, db, 5, strip.',
					'aliases' => ['m'],
				],
			],
		]);
		$args->parse();

		if ($args['help']) {
			Cli::line('' . $args->getHelpScreen());
			exit(0);
		} elseif ($args['module']) {
			$choice = match ($args['module']) {
				'1', 'vscodium' => 'VSCodiumPatcher',
				'2', 'pin' => 'PinCode',
				'3', 'package' => 'PackageLibrary',
				'4', 'db' => 'TestDBLayer',
				'5', 'strip' => 'Stripper',
				default => 'Exit',
			};
		} else {
			// Pick and choose what to run
			$menu = [
				'VSCodiumPatcher' => 'VSCodiumPatcher: update extention gallery',
				'PinCode' => 'PinCode: proof of concept',
				'PackageLibrary' => 'PackageLibrary Manager',
				'TestDBLayer' => 'Test Database Layer',
				'Stripper' => 'URL Stripper',
				'' => 'Exit',
			];

			$choice = Cli::menu($menu, null, 'Please choose the module you want to run', 1);
		}

		$result = match ($choice) {
			'PinCode' => new Dev\Task\PinCode(),
			'VSCodiumPatcher' => new Dev\Util\VSCodiumPatcher($config->vscodium)->patch(),
			'PackageLibrary' => \Dev\Package\PackageLibrary::getInstance()->run(),
			'TestDBLayer' => $testDBLayer($config),
			'Stripper' => new Dev\Strip\ImageStripper($config->imagestripper)->strip('https://fuskator.com/expanded/e8OzkzxDDbj/Teen-Lolita-Lolita-Wearing-Striped-Socks.html'),
			default => '',
		};

		if ($result != '' && $result != null && !empty($result) && $result != false) {
			// dd($result, 'Console Module Result');
		}
	}
} else {
	dd(label: 'Make a console app to manage all of this.', options: ['type' => Type::Todo]);
	Dumper::todo('kick something!', 'Another task');
	Dumper::todo(new Options(['a']), 'Another task');
	$file = 'public' . $_SERVER['REQUEST_URI'];
	// Server existing files in web dir
	if (file_exists($file) && !is_dir($file)) return false;

	\Dev\App\Application::getInstance()->run();
}
