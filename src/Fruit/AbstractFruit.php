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

namespace Dev\Fruit;

use Inane\Http\Client as HttpClient;
use Inane\Http\Request;
use Inane\Http\Response;
use Inane\Routing\Exception\InvalidRouteException;
use Inane\Routing\RouteMatch;
use Inane\Routing\Router;
use Inane\Stdlib\Options;

use const GLOB_BRACE;
use const GLOB_NOSORT;

use function glob;
use function is_array;
use function is_null;

/**
 * AbstractFruit
 *
 * Get your fruit, fresh from the factory.
 * All fruits have some things in common. These are those things.
 *
 * @version 0.1.0
 */
class AbstractFruit implements FruitInterface {
}