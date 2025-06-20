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

namespace Dev\Web;

use Dev\App\AbstractController;
use Dev\App\ModelInterface;
use Dev\App\ViewModel;
use Dev\People\Person;
use Inane\Routing\Route;

use function file_exists;

class MainController extends AbstractController {
	#[Route(path: '/', name: 'home', extra: ['label' => 'Welcome', 'title' => 'Home Page', 'class' => 'text-red'])]
	public function home(): array|ModelInterface {
		$philip = new Person('Philip', 'Raab');

		return new ViewModel([
			'developer' => $philip->fullName,
		]);
	}

	#[Route(path: '/view/{item}', name: 'item', extra: ['label' => 'Item: {item}', 'class' => 'text-purple'])]
	public function viewTask(array $params): array|ModelInterface {
		if (file_exists('public/img/' . $params["item"] . '.png')) {
			$img = '<img width="300" src="/img/' . $params["item"] . '.png" alt="' . $params["item"] . '"/>';
		} else {
			$img = '';
		}

		$params["img"] = $img;

		return new ViewModel($params);
	}
}