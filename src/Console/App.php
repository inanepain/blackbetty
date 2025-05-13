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

namespace Dev\Console;

use Dev\Config\DefaultConfigTrait;
use Inane\Dumper\Silence;
use Inane\Stdlib\Options;
use Inane\Cli\{
    Pencil\Colour,
    Pencil\Style,
    Pencil
};

/**
 * The Console Application class
 *
 * This class is the main entry point of the console application.
 *
 * @version 0.1.0
 */
final class App {
	use DefaultConfigTrait;

	/**
     * The current version of the application.
     *
     * @var string
     */
    public const string VERSION = '0.1.0';

	/**
	 * The instance of the application
	 *
	 * @var \Dev\Console\App The instance of the application
	 */
	private static App $instance;

	/**
	 * The application configuration
	 *
	 * @var \Inane\Stdlib\Options The application configuration
	 */
	public protected(set) Options $config;

	/**
     * The default configuration for the ImageStripper class.
     *
     * @var array $defaultConfig An associative array containing default settings.
     */
    protected array $defaultConfig {
        get => [];
    }

	/**
     * @var Options $pen a bunch of pretty colours for the console output.
     */
    protected Options $pen;

	/**
	 * Gets the instance of the application
	 *
	 * @return \Dev\Console\App
	 */
	public static function getInstance(): App {
		if (!isset(self::$instance))
			self::$instance = new static();

		return self::$instance;
	}

	/**
     * Constructor for the Console App.
     *
     * @param array|Options|null $config Configuration options for the Console App instance.
     */
    #[Silence(true)]
    private function __construct(array|Options|null $config = null) {
        $this->configure($config);
        $this->bootstrap();

        dd($this->config, 'Parsed Config');

		$this->pen->purple->line('Console App ' . $this->pen->white . '(' . $this->pen->blue . static::VERSION . $this->pen->white . ')');
    }

	protected function bootstrap(): void {
		if (!isset($this->pen)) $this->pen = new Options([
            'black' => new Pencil(Colour::Black),
            'blue' => new Pencil(Colour::Blue),
            'cyan' => new Pencil(Colour::Cyan),
            'green' => new Pencil(Colour::Green),
            'purple' => new Pencil(Colour::Purple),
            'red' => new Pencil(Colour::Red),
            'white' => new Pencil(Colour::White),
            'yellow' => new Pencil(Colour::Yellow, Style::Bold),
            'reset' => Pencil::reset(),
        ]);
    }


}