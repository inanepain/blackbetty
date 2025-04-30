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

use Inane\Stdlib\Options;

trait DefaultConfigTrait {
    /**
     * @var Options
     */
    protected Options $config;

    /**
     * Configures the application
     *
     * Reads the configuration files and merges them into the configuration object.
     *
     * @param array|Options|null $config Configuration options for the class. It can be an array, an instance of the Options class, or null.
     *
     * @return void
     */
    protected function configure(array|Options|null $config = null): void {
        $this->config = new Options( property_exists($this, 'defaultConfig') ? $this->defaultConfig : []);

        if ($config !== null) $this->config->merge($config);
        $this->config->lock();
    }
}