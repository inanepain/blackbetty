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

class UsersGateway {

	private \PDO|null $db = NULL;

	public function __construct(\PDO $db) {
		$this->db = $db;
	}

	public function findAll(): array {
		$statement = "
            SELECT 
                id, name, email
            FROM
                users;
        ";

		try {
			$statement = $this->db->query($statement);
			$result    = $statement->fetchAll(\PDO::FETCH_ASSOC);

			return $result;
		}
		catch (\PDOException $e) {
			exit($e->getMessage());
		}
	}

	public function find(int $id): array {
		$statement = "
            SELECT 
                id, name, email
            FROM
                users
            WHERE id = ?;
        ";

		try {
			$statement = $this->db->prepare($statement);
			$statement->execute([$id]);
			$result = $statement->fetchAll(\PDO::FETCH_ASSOC);

			return $result;
		}
		catch (\PDOException $e) {
			exit($e->getMessage());
		}
	}

	public function insert(array $input): int {
		$statement = "
            INSERT INTO users 
                (name, email)
            VALUES
                (:name, :email);
        ";

		try {
			$statement = $this->db->prepare($statement);
			$statement->execute([
				'name'       => $input['name'],
				'email'        => $input['email'],
			]);

			return $statement->rowCount();
		}
		catch (\PDOException $e) {
			exit($e->getMessage());
		}
	}

	public function update(int $id, array $input): int {
		$statement = "
            UPDATE users
            SET 
                name = :firstname,
                email  = :lastname,
            WHERE id = :id;
        ";

		try {
			$statement = $this->db->prepare($statement);
			$statement->execute([
				'id'              => (int) $id,
				'name'       => $input['name'],
				'email'        => $input['email'],
			]);

			return $statement->rowCount();
		}
		catch (\PDOException $e) {
			exit($e->getMessage());
		}
	}

	public function delete(int $id): int {
		$statement = "
            DELETE FROM users
            WHERE id = :id;
        ";

		try {
			$statement = $this->db->prepare($statement);
			$statement->execute(['id' => $id]);

			return $statement->rowCount();
		}
		catch (\PDOException $e) {
			exit($e->getMessage());
		}
	}

}