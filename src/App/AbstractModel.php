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

use function array_merge;
use function is_array;
use function property_exists;

abstract class AbstractModel implements ModelInterface {
	/**
	 * @var int http response status
	 */
	protected(set) int $status = 200;

	/**
	 * @var array http headers
	 */
	protected(set) array $headers = [];

	/**
	 * @var bool
	 */
	protected(set) bool $terminate = false;

	/**
	 * @var string
	 */
	protected(set) string $renderer;

	public function __construct(
		/**
		 * @var array view variables
		 */
		protected(set) array $variables = [],
		/**
		 * @var array options model and renderer options
		 */
		array|Options $options = [],
	) {
		$this->setOptions($options);
	}

	/**
	 * Set options to generic values
	 *
	 * Only options not yet set via other means will be set
	 *
	 * @param   array|\Inane\Stdlib\Options  $options
	 *
	 * @return $this
	 */
	public function setOptions(array|Options $options): self {
		foreach ($options as $key => $value) {
			if (property_exists($this, $key)) {
				if ($key === 'headers' && is_array($value)) {
					$this->headers = array_merge($this->headers, $value);
					continue;
				}
				$this->$key = $value;
			}
		}
		return $this;
	}
}