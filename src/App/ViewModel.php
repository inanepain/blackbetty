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

	protected static array $scripts = [];

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
}