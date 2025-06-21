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

use Inane\Routing\Router;
use Inane\Stdlib\Options;
use Inane\View\Renderer\PhpRenderer;

use function array_merge;
use function array_reverse;
use function implode;

/**
 * ViewModel
 *
 * @package Develop\Tinker
 */
class ViewModel extends AbstractModel {
	/**
	 * @var string
	 */
	protected(set) string $template = '';

	/**
	 * @var string
	 */
	protected(set) string $layout = '';

	/**
	 * @var string
	 */
	protected(set) string $renderer = PhpRenderer::class;

	protected Options $properties;

	protected static array $scripts = [];

	public function setProperties(array|Options $properties): void {
		$this->properties = new Options($properties);
	}

	public function appendScript(string $script, bool $module = false): self {
		$type = $module ? 'module' : 'text/javascript';
		$this::$scripts[] = "<script src=\"$script\" type=\"$type\"></script>";

		return $this;
	}

	public function prependScript(string $script, bool $module = false): self {
		$type = $module ? 'module' : 'text/javascript';
		$this::$scripts = array_merge(["<script src=\"$script\" type=\"$type\"></script>"], $this::$scripts);

		return $this;
	}

	public function getScripts(): string {
		return implode("\n", array_reverse($this::$scripts));
	}

	/**
	 * Get options
	 *
	 * @return \Inane\Stdlib\Options current options
	 */
	public function getOptions(): Options {
		return new Options([
			'template' => $this->template,
			'layout' => $this->layout,
			'terminate' => $this->terminate,
			'renderer' => $this->renderer,
			'status' => $this->status,
			'headers' => $this->headers,
		]);
	}

	public function getProperty(string $name): string {
		return $this->properties->get($name, '');
	}

	public function getLink(string $routeName, array $params = []): string {
		$router = \Dev\App\Application::getInstance()->router;
		$data = [
			'{url}' => $router->url($routeName, $params),
			'{label}' => $router->routeProperty($routeName, 'label', $params),
			'{title}' => $router->routeProperty($routeName, 'title', $params),
			'{class}' => $router->routeProperty($routeName, 'class', $params),
			'{target}' => $router->routeProperty($routeName, 'target', $params),
		];

		$template = '<a class="link item {class}" title="{title}" href="{url}">{label}</a><br />';
		$link = strtr($template, $data);
		return $link;
	}
}
