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

use Dev\App\AbstractModel;

/**
 * JsonModel
 *
 * @version 0.1.0
 */
class JsonModel extends AbstractModel {
	/**
	 * @var bool
	 */
	protected(set) bool $terminate = true;

	/**
	 * @var array http headers
	 */
	protected(set) array $headers = [
		'Content-Type' => 'application/json',
	];

	/**
	 * @var string
	 */
	protected(set) string $renderer = JsonRenderer::class;
}