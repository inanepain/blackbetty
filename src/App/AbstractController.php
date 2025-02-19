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

namespace Dev\App;

use Inane\Http\Request;
use Inane\Http\Response;
use Inane\Routing\RouteMatch;

use function method_exists;

/**
 * AbstractController
 *
 * @package Develop\Tinker
 */
abstract class AbstractController {
	protected RouteMatch $routeMatch;
	protected Request $request;
	protected Response $response;

		public function __construct() {
			$app = Application::getInstance();
			$this->routeMatch = $app->routeMatch;
			$this->request = $app->request;
			$this->response = $app->response;

			if (method_exists($this, 'initialise'))
				$this->initialise();
		}
}