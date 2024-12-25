<?php

/**
 * Develop
 *
 * Tinkering development environment. Used to play with or try out stuff.
 *
 * PHP version 8.3
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

namespace Dev\App;

/**
 * AbstractRestController
 *
 * @package Develop\Tinker
 */
abstract class AbstractRestController extends AbstractController {

	/**
	 * Creates a standard message package
	 *
	 * @param   string          $message
	 * @param   array|int|null  $data
	 * @param   bool            $success
	 * @param   array           $vars
	 *
	 * @return array
	 */
	protected function createMessage(string $message, array|int|null $data = NULL, bool $success = TRUE, array $vars = []): array {
		$package = [
			           'message' => $message,
			           'success' => $success,
		           ] + $vars;

		if ($package['success'] == FALSE) {
			$package['data'] = $package;
		} else {
			$package['data'] = $data ?? $this->users;
		}

		return $package;
	}

}
