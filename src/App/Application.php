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

use Inane\Http\Client as HttpClient;
use Inane\Http\Request;
use Inane\Http\Response;
use Inane\Routing\Exception\InvalidRouteException;
use Inane\Routing\RouteMatch;
use Inane\Routing\Router;
use Inane\Stdlib\Options;

use const GLOB_BRACE;
use const GLOB_NOSORT;
use const true;

use function glob;
use function is_array;
use function is_null;

/**
 * The application class
 *
 * This class is the main entry point of the application. It is responsible for setting up the application, routing the request to the controller, rendering the view and sending the response to the client.
 *
 * @version 0.1.0
 */
final class Application {

	/**
	 * The instance of the application
	 *
	 * @var \Dev\App\Application The instance of the application
	 */
	private static Application $instance;

	/**
	 * The application configuration
	 *
	 * @var \Inane\Stdlib\Options The application configuration
	 */
	public protected(set) Options $config;

	/**
	 * The router object
	 *
	 * @var \Inane\Routing\Router The router object
	 */
	protected(set) Router $router;

	/**
	 * The matched route
	 *
	 * @var \Inane\Routing\RouteMatch The matched route
	 */
	public protected(set) ?RouteMatch $routeMatch;

	/**
	 * @var \Dev\App\ViewManager The view object
	 */
	protected ViewManager $view;

	/**
	 * @var \Inane\Http\Request The request object read from View
	 */
	protected(set) Request $request {
		get => $this->view->request;
		set {}
	}

	/**
	 * @var \Inane\Http\Response The response object read from View
	 */
	protected(set) Response $response {
		get => $this->view->response;
		set {}
	}

	/**
	 * @var \Inane\Http\Client The HTTP client object
	 */
	protected HttpClient $httpClient;

	/**
	 * The constructor
	 *
	 * The constructor is private to prevent creating multiple instances of the application.
	 *
	 * @return void
	 */
	private function __construct() {
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
		$this->configure();

		$this->router = new Router(splitQuerystring: true);
		$this->router->addRoutes($this->config->router->controllers);

		$this->view = new ViewManager($this->config->view->path);
		$this->httpClient = new HttpClient();
	}

	/**
	 * Configures the application
	 *
	 * Reads the configuration files and merges them into the configuration object.
	 *
	 * @return void
	 */
	protected function configure(): void {
		$this->config = new Options(include 'config/app.config.php');

		$files = glob('config/autoload/{{,*.}global,{,*.}local}.php', GLOB_BRACE | GLOB_NOSORT);
		foreach ($files as $file) $this->config->merge(include $file);

		$this->config->lock();
	}

	/**
	 * Runs the application
	 *
	 * @return never
	 */
	public function run(): never {
		$this->routing();
		$this->rendering();
		$this->responding();
	}

	/**
	 * Routes the request to the controller
	 *
	 * @return void
	 *
	 * @throws \Inane\Stdlib\Exception\BadMethodCallException
	 * @throws \Inane\Stdlib\Exception\UnexpectedValueException
	 * @throws \ReflectionException
	 */
	protected function routing(): void {
		$this->routeMatch = $this->router->match($this->request);

		if (is_null($this->routeMatch))
			throw new InvalidRouteException('Request Error: Unmatched `file` or `route`!', AppError::InvalidRoute->value);
	}

	/**
	 * Generates the view content
	 *
	 * @return void
	 *
	 * @throws \Inane\View\Exception\RuntimeException
	 */
	protected function rendering(): void {
		// TODO: Check for REST controller and structure method calls based on command.
		$controller = new $this->routeMatch->class();
		$modelOrArray = $controller->{$this->routeMatch->method}($this->routeMatch->params);
		$model = is_array($modelOrArray) ? new ViewModel($modelOrArray) : $modelOrArray;

		if (!$model->terminate) $model->setOptions([
			'template' => $this->routeMatch->template,
			'layout' => $this->config->view->layout,
		]);

		$this->view->render($model);
	}

	/**
	 * Sends the response to client
	 *
	 * @return never
	 */
	protected function responding(): void {
		$this->httpClient->send($this->response);
	}

	/**
	 * Gets the instance of the application
	 *
	 * @return \Dev\App\Application
	 */
	public static function getInstance(): Application {
		if (!isset(self::$instance))
			self::$instance = new static();

		return self::$instance;
	}
}