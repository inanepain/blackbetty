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

use Inane\Stdlib\Json;
use Inane\View\Renderer\RendererInterface;

use function is_array;

/**
 * JsonRenderer
 *
 * Renders arrays into JSON strings
 *
 * @package Inane\View
 *
 * @version 0.1.0
 */
class JsonRenderer implements RendererInterface {
	/**
	 * Encoding options
	 *
	 * @see https://www.php.net/manual/en/function.json-encode.php
	 *
	 * @var array
	 */
	protected static array $encodingOptions = [];

	/**
	 * Renders an array of data into a JSON string
	 *
	 * $encodingOptions OPTIONS (string values ignored):
	 *  - (bool) [pretty=false] format result
	 *  - (bool) [numeric=true] check for numeric values
	 *  - (bool) [hex=false] encode ',<,>,",& are encoded to \u00*
	 *  - (int) [flags=0] Bitmask consisting of JSON_FORCE_OBJECT, JSON_HEX_QUOT, JSON_HEX_TAG, JSON_HEX_AMP, JSON_HEX_APOS, JSON_INVALID_UTF8_IGNORE, JSON_INVALID_UTF8_SUBSTITUTE, JSON_NUMERIC_CHECK, JSON_PARTIAL_OUTPUT_ON_ERROR, JSON_PRESERVE_ZERO_FRACTION, JSON_PRETTY_PRINT, JSON_UNESCAPED_LINE_TERMINATORS, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE, JSON_THROW_ON_ERROR. The behaviour of these constants is described on the JSON constants page.
	 *
	 * EXAMPLE:
	 * ['pretty' => true,]
	 *
	 * @param array $options encoding options
	 */
	public function __construct(string|array $encodingOptions = '') {
		if (is_array($encodingOptions))
			static::$encodingOptions = $encodingOptions;
	}

	/**
	 * @inheritDoc
	 */
	public function render(string $template, array $data = []): string {
		return static::renderTemplate($template, $data);
	}

	/**
	 * @inheritDoc
	 */
	public static function renderTemplate(string $template, array $data = []): string {
		return Json::encode($data, static::$encodingOptions);
	}
}