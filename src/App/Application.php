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

use Inane\File\File;
use Inane\Http\Client as HttpClient;
use Inane\Http\Request;
use Inane\Http\Response;
use Inane\Routing\Router;
use Inane\Stdlib\Json;
use Inane\Stdlib\Options;
use Inane\View\Renderer\PhpRenderer;
use Inane\View\Renderer\RendererInterface;
use Inane\Stdlib\ArrayObject;

final class Application {
	private static Application $instance;

	protected Options $config;

	protected Router $router;

	protected(set) Request $request;
	protected Response $response;
	protected HttpClient $httpClient;

	protected RendererInterface $renderer;

	protected Options $runenv;

	private function __construct() {
		$this->config = new Options(include 'config/app.config.php');

		$this->router = new Router();
		$this->request = new Request();
		$this->httpClient = new HttpClient();

		$this->renderer = new PhpRenderer($this->config->view->path);

		$this->response = $this->request->getResponse();
		$this->runenv = new Options([
			'route' => [
				'match' => null,
				'controller' => null,
			],
			'view' => [
				'layout' => null,
				'data' => null,
				'path' => $this->config->view->path,
				'file' => null,
				'content' => null,
			],
			'render' => [
				'html' => null,
			],
		]);
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
		$this->router->addRoutes($this->config->router->controllers);

		$this->runenv->route->match = $this->router->match();

		if ($this->runenv->route->match) {
			$this->runenv->route->controller = new $this->runenv->route->match['class']();
			$this->runenv->view->data = $this->runenv->route->controller->{$this->runenv->route->match['method']}($this->runenv->route->match->params->toArray()) + ['raw' => false];
		} else {
			throw new Exception('Request Error: Unmatched `file` or `route`!');
		}
	}

	/**
	 * Generates the view content
	 *
	 * @return void
	 *
	 * @throws \Inane\View\Exception\RuntimeException
	 */
	protected function rendering(): void {
		$this->runenv->view->layout = new ArrayObject(['content' => '']);

		if ($this->runenv->view->data->raw == false) {
			$path = explode('\\', $this->runenv->route->match['class']);
			$this->runenv->view->path = implode(DIRECTORY_SEPARATOR, [
				str_replace('Controller', '', array_pop($path)),
				str_replace('Task', '', $this->runenv->route->match['method'])
			]);

			$this->runenv->view->file = new File($this->config->view->path . DIRECTORY_SEPARATOR . $this->runenv->view->path . '.phtml');
			$this->runenv->view->content = $this->runenv->view->file->isValid() ? $this->renderer->render($this->runenv->view->path, $this->runenv->view->data) : '';

			$this->runenv->view->layout->content = $this->runenv->view->layout->content;
			$this->runenv->render->html = $this->renderer->render($this->config->view->layout, [], $this->runenv->view->layout);


		} else {
			$this->runenv->render->html = Json::encode($this->runenv->view->data['data']);
			$this->response->addHeader('Content-Type', 'application/json');
		}
	}

	/**
	 * Sends the response to client
	 *
	 * @return void
	 */
	protected function responding(): void {
		$this->response->setBody($this->runenv->render->html);
		$this->httpClient->send($this->response);
	}

	/**
	 * Runs the application
	 *
	 * @return void
	 */
	public function run(): void {
		$this->routing();
		$this->rendering();
		$this->responding();
	}

	/**
	 * Gets the instance of the application
	 *
	 * @return \Dev\App\Application
	 */
	public static function getInstance(): Application {
		if (!isset(self::$instance)) {
			self::$instance = new static();
		}
		return self::$instance;
	}
}