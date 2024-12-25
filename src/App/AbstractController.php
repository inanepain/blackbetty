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

namespace Dev\App;

use Inane\Http\Request;

/**
 * AbstractController
 *
 * @package Develop\Tinker
 */
abstract class AbstractController {
	protected Request $request;

		public function __construct() {
			$this->request = Application::getInstance()->request;

			if (method_exists($this, 'initialise'))
				$this->initialise();
		}
}