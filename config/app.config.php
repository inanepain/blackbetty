<?php

/**
 * Develop
 *
 * Tinkering development environment. Used to play with or try out stuff.
 *
 * PHP version 8.4
 *
 * @author  Philip Michael Raab<philip@cathedral.co.za>
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
	'view'   => [
		'path'   => 'View',
		'layout' => 'layout/layout',
	],
	'router' => [
		'controllers' => [
			\Dev\Web\MainController::class,
			\Dev\Parse\ParseController::class,
			\Dev\Rest\UserController::class,
			\Dev\Controller\DevController::class,
		],
	],
];
