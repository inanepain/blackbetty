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

use Inane\Stdlib\Options;
use Inane\View\Renderer\PhpRenderer;

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