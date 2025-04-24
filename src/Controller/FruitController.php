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

namespace Dev\Controller;

use Dev\App\AbstractController;
use Dev\App\ModelInterface;
use Dev\App\ViewModel;
use Dev\People\Person;
use Inane\Http\HttpMethod;
use Inane\Routing\Route;

use function file_exists;

class FruitController extends AbstractController {
	#[Route(path: '/fruit', name: 'fruit', methods: [HttpMethod::Get])]
	public function storeTask(): array|ModelInterface {

		return new ViewModel([]);
	}
}