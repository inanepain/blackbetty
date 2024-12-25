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

namespace Dev\Web;

use Dev\People\Person;
use Inane\Routing\Route;

class MainController {
	#[Route(path: '/', name: 'home')]
	public function home(): array {
		$philip = new Person('Philip', 'Raab');
		return [
			'developer' => $philip->fullName,
		];
	}

	#[Route(path: '/view/{item}', name: 'item', )]
	public function viewTask(array $params): array {
		if (file_exists('public/img/' . $params["item"] . '.png')) {
			$img = '<img width="300" src="/img/' . $params["item"] . '.png" alt="' . $params["item"] . '"/>';
		} else {
			$img = '';
		}

		$params["img"] = $img;
		return $params;
	}
}