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

use PDO;

/**
 * UsersGateway
 *
 * @package Dev\Db
 */
class UsersGateway {
	private \PDO|null $db = NULL;

	/**
	 * Constructor
	 *
	 * @param PDO $db
	 * @return void
	 */
	public function __construct(\PDO $db) {
		$this->db = $db;
	}

	/**
	 * Retrieves all user records from the database.
	 *
	 * @return array An array of all user records.
	 */
	public function findAll(): array {
		$statement = "
            SELECT
                id, name, email, group
            FROM
                users;
        ";

		try {
			$statement = $this->db->query($statement);
			$result    = $statement->fetchAll(\PDO::FETCH_ASSOC);

			return $result;
		} catch (\PDOException $e) {
			exit($e->getMessage());
		}
	}

	/**
	 * Finds a user by their ID.
	 *
	 * @param int $id The ID of the user to find.
	 *
	 * @return array The user data as an associative array.
	 */
	public function find(int $id): array {
		$statement = "
            SELECT
                id, name, email, group
            FROM
                users
            WHERE id = ?;
        ";

		try {
			$statement = $this->db->prepare($statement);
			$statement->execute([$id]);
			$result = $statement->fetchAll(\PDO::FETCH_ASSOC);

			return $result;
		} catch (\PDOException $e) {
			exit($e->getMessage());
		}
	}

	/**
	 * Inserts a new record into the users table.
	 *
	 * @param array $input An associative array containing the data to be inserted.
	 *
	 * @return int The ID of the newly inserted record.
	 */
	public function insert(array $input): int {
		$statement = "
            INSERT INTO users
                (name, email, group)
            VALUES
                (:name, :email, :group);
        ";

		try {
			$statement = $this->db->prepare($statement);
			$statement->execute([
				'name'       => $input['name'],
				'email'        => $input['email'],
				'group'        => $input['group'],
			]);

			return $statement->rowCount();
		} catch (\PDOException $e) {
			exit($e->getMessage());
		}
	}

	/**
	 * Updates a user's information in the database.
	 *
	 * @param int $id The ID of the user to update.
	 * @param array $input An associative array of the user's new data.
	 *
	 * @return int The number of affected rows.
	 */
	public function update(int $id, array $input): int {
		$statement = "
            UPDATE users
            SET
                name = :name,
                email = :email,
                group = :group,
            WHERE id = :id;
        ";

		try {
			$statement = $this->db->prepare($statement);
			$statement->execute([
				'id' => (int) $id,
				'name' => $input['name'],
				'email' => $input['email'],
				'group' => $input['group'],
			]);

			return $statement->rowCount();
		} catch (\PDOException $e) {
			exit($e->getMessage());
		}
	}

	/**
	 * Deletes a user from the database.
	 *
	 * @param int $id The ID of the user to delete.
	 *
	 * @return int The number of rows affected by the delete operation.
	 */
	public function delete(int $id): int {
		$statement = "
            DELETE FROM users
            WHERE id = :id;
        ";

		try {
			$statement = $this->db->prepare($statement);
			$statement->execute(['id' => $id]);

			return $statement->rowCount();
		} catch (\PDOException $e) {
			exit($e->getMessage());
		}
	}
}
