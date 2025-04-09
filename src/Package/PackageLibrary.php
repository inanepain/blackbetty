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

namespace Dev\Package;

use Dev\Config\ConfigTrait;
use Inane\File\Path;
use Inane\Stdlib\Options;

use const GLOB_ONLYDIR;

/**
 * PackageLibrary
 *
 * @package Develop\Package
 */
final class PackageLibrary {
    use ConfigTrait;

    /**
     * PackageLibrary instance for singleton
     *
     * @var PackageLibrary
     */
    private static PackageLibrary $instance;

    protected Options $config;

    protected Options $library;

    /**
	 * Gets the instance of PackageLibrary
	 *
	 * @return \Dev\Package\PackageLibrary The instance of PackageLibrary
	 */
	public static function getInstance(): static {
		if (!isset(self::$instance))
			self::$instance = new static();

		return self::$instance;
	}

    /**
     * Private constructor for singleton
     *
     * @return void
     */
    private function __construct() {
        $this->config = $this->getConfig()->package_library;

        $this->bootstrap();
    }

    /**
	 * Sets up the application
	 *
	 * Creates requiered objects and configuration them so that everything is ready to run.
	 *
	 * @return void
	 */
	protected function bootstrap(): void {
        $this->library = new Options([
            'path' => new Path($this->config->path),
            'vendors' => [],
        ]);

		$vendors = $this->library->path->getFiles('*', GLOB_ONLYDIR);

        foreach ($vendors as $vendor) {
            $this->library->vendors[$vendor->getBaseName()] = [
                'name' => $vendor->getBaseName(),
                'path' => $vendor,
                'packages' => [],
            ];

            foreach ($vendor->getFiles('*', GLOB_ONLYDIR) as $package) {
                $this->library->vendors[$vendor->getBaseName()]['packages'][$package->getBaseName()] = [
                    'vendor' => $vendor->getBaseName(),
                    'package' => $package->getBaseName(),
                    'name' => $vendor->getBaseName() . '/' . $package->getBaseName(),
                    'path' => $package,
                ];
            }
        }
        dd($this->library->toArray(), 'lib', ['useVarExport' => true]);
	}

    public function run(): void {
        dd($this->config);
    }
}
