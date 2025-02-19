<?php

/**
 * Develop
 *
 * Tinkering development environment. Used to play with or try out stuff.
 *
 * PHP version 8.4
 *
 * @author  Philip Michael Raab<philip@cathedral.co.za>
 * @package Develop\Tinker
 *
 * @license UNLICENSE
 * @license https://unlicense.org/UNLICENSE UNLICENSE
 *
 * @version $Id$
 * $Date$
 */

declare(strict_types=1);

namespace Dev\Db;

class DatabaseConnector {

	private \PDO|null $dbConnection = NULL;

	public function __construct() {
		try {
			$this->dbConnection = new \PDO('sqlite:data/develop.db');
		}
		catch (\PDOException $e) {
			exit($e->getMessage());
		}
	}

	public function getConnection(): \PDO {
		return $this->dbConnection;
	}

}