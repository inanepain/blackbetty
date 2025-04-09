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

namespace Dev\Config;

use Inane\Stdlib\Options;

use function glob;

use const GLOB_BRACE;
use const GLOB_NOSORT;

/**
 * ConfigTrait
 *
 * @version 0.1.0
 */
trait ConfigTrait {
    protected static string $baseConfigFile = 'config/app.config.php';

    /**
     * The glob pattern used to locate configuration files.
     *
     * If a pattern is found in BaseConfig['config']['glob_pattern'], it will be used instead.
     *
     * This pattern supports the following structure:
     * - Files in the "config/autoload" directory.
     * - The pattern matches both global and local configuration files.
     * - Global configuration files are prefixed with "global" (e.g., "global.php" or "*.global.php").
     * - Local configuration files are prefixed with "local" (e.g., "local.php" or "*.local.php").
     * - Local configuration files take preference over global configuration files and should not be checked into git.
     *
     * The pattern uses curly braces to define multiple matching options.
     *
     * @var string
     */
    protected static string $configGlobPattern = 'config/autoload/{{,*.}global,{,*.}local}.php';

    protected function getConfig(): Options {
        $config = new Options(include static::$baseConfigFile);
        $pattern = $config->config->glob_pattern ?? static::$configGlobPattern;

        $files = glob($pattern, GLOB_BRACE | GLOB_NOSORT);
        foreach ($files as $file) $config->merge(include $file);
        $config->lock();

        return $config;
    }
}