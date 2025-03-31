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

use Dev\Db\User;
use Dev\Db\UsersTable;
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

	UsersTable::$db = new PDO('sqlite:data\develop.db');

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

	// $users[0]->email;
	// $user3->email = '';
	// dd($user3);
	// dd($user4);

	// $user2 = new User();
	// $user2->get(2);
	// dd($user2);

	// $usersTable->delete($user);
	// $user2->name = 'Kayon';
	// $user->email = 'kayon@develop';
	// $user->group = 'admin';

	// $usersTable->update($user);
	// dd($users);

	// $d = new User();
	// $d->name = 'Bob';
	// $d->email = 'bob@email.co.za';
	// $d->group = 'user';

	// $usersTable->insert($d);
	// dd($d);
} else {
	$file = 'public' . $_SERVER['REQUEST_URI'];
	// Server existing files in web dir
	if (file_exists($file) && !is_dir($file)) return false;

	\Dev\App\Application::getInstance()->run();
}
