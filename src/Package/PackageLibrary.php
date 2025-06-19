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
use Inane\Cli\Arguments;
use Inane\Cli\Cli;
use Inane\Dumper\Silence;
use Inane\File\Path;
use Inane\Stdlib\Options;

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

	// protected Options $packageTemplate;
	protected array $packageTemplate;

	protected Options $library;

	/**
	 * @var Arguments $args The parsed command line arguments.
	 */
	protected Arguments $args;

	/**
	 * Gets the instance of PackageLibrary
	 *
	 * @return \Dev\Package\PackageLibrary The instance of PackageLibrary
	 */
	public static function getInstance(): static {
		if (!isset(self::$instance)) {
			self::$instance = new static();
		}

		return self::$instance;
	}

	/**
	 * Private constructor for singleton
	 *
	 * @return void
	 */
	private function __construct() {
		$this->config = $this->getConfig()->package_library;
		$this->packageTemplate = $this->getConfig()->package->default->toArray();

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
		if (!isset($this->library)) {
			$this->library = new Options([
				'path'    => new Path($this->config->path),
				'vendors' => [],
			]);

			/**
			 * @var \Inane\File\Path $this->library->path
			 */
			$vendors = $this->library->path->getDirectories('{cathedral,inanepain}');

			// populate the library with vendors and packages
			/**
			 * @var \Inane\File\Path $vendor
			 */
			foreach ($vendors as $vendor) {
				$this->library->vendors[$vendor->getBaseName()] = [
					'name'     => $vendor->getBaseName(),
					'path'     => $vendor,
					'packages' => [],
				];

				// Populate the packages for each vendor
				/**
				 * @var \Inane\File\Path $package
				 */
				foreach ($vendor->getDirectories() as $package) {
					$composerJson = $this->composerMake($package);

					$this->library->vendors[$vendor->getBaseName()]['packages'][$package->getBaseName()] = [
						'vendor'  => $vendor->getBaseName(),
						'package' => $package->getBaseName(),
						'name'    => $vendor->getBaseName() . '/' . $package->getBaseName(),
						'path'    => $package,
						'composer' => $composerJson,
					];
				}
			}
		}

		$this->parseArguments();
	}

	/**
	 * Parses the command line arguments.
	 *
	 * This method processes the arguments passed to the script and sets the
	 * appropriate properties or variables based on the input.
	 *
	 * @return void
	 */
	protected function parseArguments(): void {
		$this->args = new Arguments([
			'flags' => [
				'print' => [
					'description' => 'Print the generated composer.json to screen.',
					'aliases' => ['p'],
				],
				'write' => [
					'description' => 'Write the generated composer.json to disk.',
					'aliases' => ['w'],
				],
				'help' => [
					'description' => 'Shows the usage screen with flags and options explained.',
					'aliases' => ['h'],
				],
				'vendors' => [
					'description' => 'Lists avalable vendors.',
					// 'aliases' => ['v'],
				],
				'packages' => [
					'description' => 'Lists packages by vendor.',
					// 'aliases' => ['p'],
				],
				// 'online' => [
				//     'description' => 'Search Yts api otherwise only searches local data.',
				//     'default' => static::$config->args->online,
				//     'aliases' => ['o'],
				// ],
				// 'update' => [
				//     'description' => 'Update cache with latest online movies.',
				//     'aliases' => ['u'],
				// ],
				'verbose' => [
					'description' => 'Show more messages. Can stack for more details.',
					'aliases' => ['v'],
					'stackable' => true,
				],
			],
			'options' => [
				'name' => [
					'description' => 'Specify the name of the package to create (vender/package).',
					'aliases' => ['n'],
				],
				// 'query' => [
				//     'description' => 'Search query',
				//     'aliases' => ['q'],
				// ],
				// 'page' => [
				//     'description' => 'Page to return. (default: 1)',
				//     'aliases' => ['p'],
				//     'default' => 1,
				// ],
				// 'year' => [
				//     'description' => 'Search query by year',
				//     'aliases' => ['y'],
				// ],
				// 'limit' => [
				//     'description' => 'Limit returned movies. (default/max: ' . static::$config->args->limit . ')',
				//     'aliases' => ['l'],
				//     'default' => static::$config->args->limit,
				// ],
			],
		]);

		$this->args->parse();
		// $this->args['limit'] = intval($this->args['limit']);
	}

	#region Composer

	protected function composerMake(Path $package): Options {
		$vendor = $package->getParent();

		$composerJson = new Options($this->packageTemplate);
		$composerJson->set('name', $vendor->getBaseName() . '/' . $package->getBaseName());
		$composerJson->set('description', $package->getFile('.git/description')->read());

		$this->composerMakeScripts($composerJson, $package);

		return $composerJson;
	}

	protected function composerMakeScripts(Options &$composerJson, Path $package): void {
		$build = [];

		if ($package->getFile('doc/changelog/index.adoc')->isValid()) {
			$composerJson->scripts->set('build-changelog', [
				"del CHANGELOG.adoc",
				"asciidoctor-reducer -o CHANGELOG.adoc doc/changelog/index.adoc",
				"asciidoctor -b docbook CHANGELOG.adoc",
				"del CHANGELOG.md",
				"pandoc -f docbook -t markdown_strict CHANGELOG.xml -o CHANGELOG.md",
				"del CHANGELOG.xml"
			]);

			$build[] = '@build-changelog';
		}

		if ($package->getFile('doc/readme/index.adoc')->isValid()) {
			$composerJson->scripts->set('build-readme', [
				"del README.adoc",
				"asciidoctor-reducer -o README.adoc doc/readme/index.adoc",
				"asciidoctor -b docbook README.adoc",
				"del README.md",
				"pandoc -f docbook -t markdown_strict README.xml -o README.md",
				"del README.xml"
			]);

			$build[] = '@build-readme';
		}

		if (!empty($build)) {
			$composerJson->scripts->set('build', $build);
		}
	}

	#endregion Composer

	#region Library Access

	protected function getLibraryVendor(string $vendorName): ?Options {
		if (!$this->library->vendors->has($vendorName)) {
			Cli::err("Vendor '$vendorName' does not exist.");
			return null;
		}

		return $this->library->vendors->get($vendorName);
	}

	protected function getLibraryVendorPackage(string $vendorName, string $packageName): ?Options {
		if (!$vendor = $this->getLibraryVendor($vendorName)) {
			Cli::err("Vendor '$vendorName' does not exist.");
			return null;
		}

		if (!$vendor->packages->has($packageName)) {
			Cli::err("Package '$vendorName/$packageName' does not exist.");
			return null;
		}

		return $vendor->packages->get($packageName);
	}

	protected function getLibraryPackageByName(string $packageName): ?Options {
		[$vendorName, $packageName] = \explode('/', $this->args['name'], 2);

		return $this->getLibraryVendorPackage($vendorName, $packageName);
	}

	#endregion Library Access

	#[Silence(\true)]
	public function run(): void {
		if ($this->args['help']) {
			Cli::line((string) $this->args->getHelpScreen());
		} elseif ($this->args['vendors']) {
			Cli::line('Available vendors:');
			echo \implode(\PHP_EOL, $this->library->vendors->keys());

			// echo $this->library->vendors->inanepain->packages->stdlib->composer->toJson();
			echo $this->library->vendors->inanepain->packages->datetime->composer->toJson(JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
		} elseif ($this->args['packages']) {
		} elseif ($this->args['name']) {
			$pkg = $this->getLibraryPackageByName($this->args['name']);

			if ($this->args['print']) {
				Cli::line("JSON for package: '" . $pkg['name'] . "':");
				Cli::line($pkg->composer->toJson(JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP));
			}
		}

		dd($this->config);
		// dd($this->library->toArray(), 'lib', ['useVarExport' => true]);
		dd($this->library->vendors->inanepain->packages->keys(), 'lib', ['useVarExport' => true]);
		dd($this->library->vendors->inanepain->packages->stdlib, 'lib', ['useVarExport' => true]);
	}
}
