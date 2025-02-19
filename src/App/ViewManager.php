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

use Inane\Http\Request;
use Inane\Http\Response;

use function property_exists;

/**
 * ViewManager
 *
 * @version 0.1.0
 */
class ViewManager {
	/**
	 * @var \Inane\Http\Request
	 */
	protected(set) Request $request;
	/**
	 * @var \Inane\Http\Response
	 */
	protected(set) Response $response;

	/**
	 * View constructor.
	 *
	 * @param string $viewBasePath The base path for the views
	 */
	public function __construct(protected string $viewBasePath = '') {
		$this->request = new Request();
		$this->response = $this->request->getResponse();
	}

	/**
	 * Render
	 *
	 * Returns the rendered content as well as setting the response body and status
	 *
	 * @param ModelInterface $model
	 *
	 * @return string rendered content
	 */
	public function render(ModelInterface $model): string {
		$renderer = new $model->renderer($this->viewBasePath);
		$rendered = $renderer->render(property_exists($model, 'template') ? $model->template : '', $model->variables, $model);

		if (!$model->terminate) {
			/**
			 * @var \Dev\App\ViewModel $model
			 */
			$o = $model->getOptions();
			$o->content = $rendered;
			$rendered = $renderer->render($o->layout, [], $o);
		}

		foreach ($model->headers as $key => $value)
			$this->response->addHeader($key, $value);

		$this->response->setBody($rendered);
		$this->response->setStatus($model->status);

		return $rendered;
	}
}