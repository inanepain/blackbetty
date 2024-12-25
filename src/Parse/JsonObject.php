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

namespace Dev\Parse;

use Inane\Stdlib\Json;

class JsonObject {
    public private(set) string $version = '8.4';

    public array $jsonObject {
		set (array $jsonObject) {
			$this->jsonObject = $jsonObject;
		}
    }

    public string $jsonString {
	    get {
			return Json::encode($this->jsonObject);
		}
        set (string $jsonString) {
            $this->jsonObject = Json::decode($jsonString);
            $this->jsonString = $jsonString;
        }
    }
}