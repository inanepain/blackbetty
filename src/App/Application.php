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

use Inane\Http\Client as HttpClient;
use Inane\Http\Request;
use Inane\Http\Response;
use Inane\Routing\Exception\InvalidRouteException;
use Inane\Routing\RouteMatch;
use Inane\Routing\Router;
use Inane\Stdlib\Options;
use Inane\View\Renderer\RendererInterface;

use function is_array;
use function is_null;

final class Application {

	/**
	 * @var \Dev\App\Application The instance of the application
	 */
	private static Application $instance;

	/**
	 * @var \Inane\Stdlib\Options The application configuration
	 */
	protected(set) Options $config;

	protected Router $router;
	protected(set) ?RouteMatch $routeMatch;

	protected View $view;
	protected(set) Request $request;
	protected(set) Response $response;
	protected HttpClient $httpClient;

	protected RendererInterface $renderer;

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
		$this->config = new Options(include 'config/app.config.php', false);

		$this->router = new Router();
		$this->router->addRoutes($this->config->router->controllers);

		$this->view = new View($this->config->view->path);
		$this->request = $this->view->request;
		$this->response = $this->view->response;

		$this->httpClient = new HttpClient();
	}

	/**
	 * Runs the application
	 *
	 * @return void
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
		$this->routeMatch = $this->router->match($this->view->request);

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
	protected function responding(): never {
		$this->httpClient->send($this->view->response);
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