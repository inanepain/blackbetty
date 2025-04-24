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
use Inane\Http\HttpMethod;
use Inane\Routing\Route;

class DevController extends AbstractController {
	#[Route(path: '/dev', name: 'develop', methods: [HttpMethod::Get])]
	public function developTask(): array|ModelInterface {
		return new ViewModel([]);
	}
}