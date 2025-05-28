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
	'config' => [
		'glob_pattern' => realpath(__DIR__) . '/autoload/{{,*.}global,{,*.}local}.php',
	],
	'view'   => [
		'path'   => 'View',
		// 'layout' => 'layout/layout',
		'layout' => 'layout/lo2',
	],
	'router' => [
		'controllers' => [
			\Dev\Web\MainController::class,
			\Dev\Parse\ParseController::class,
			\Dev\Rest\UserController::class,
			\Dev\Rest\UsersController::class,
			\Dev\Controller\DevController::class,
		],
	],
];
