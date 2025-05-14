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

namespace Dev\Rest;

use Dev\App\AbstractRestController;
use Dev\App\JsonModel;
use Dev\App\ModelInterface;
use Inane\File\File;
use Inane\Http\HttpMethod;
use Inane\Routing\Route;
use Inane\Stdlib\Json;

use function array_filter;
use function array_find;
use function array_intersect_key;
use function array_merge;
use function array_reduce;
use function array_values;
use function count;
use function intval;
use function is_numeric;
use function array_key_exists;

/**
 * UserController
 *
 * @version 0.1.0
 */
class UsersController extends AbstractRestController {
	private File $db;

	private static array $template = [
		'id' => 0,
		'name' => '',
		'email' => '',
		'group' => '',
	];

	private(set) array $users = [
		[
			'id' => 1,
			'name' => 'Philip Raab',
			'email' => 'philip@users.com',
		],
		[
			'id' => 2,
			'name' => 'Nicole Raab',
			'email' => 'nicole@users.com',
		],
	];

	/**
	 * Initialise object
	 *
	 * @return void
	 */
	protected function initialise(): void {
		$this->db = new File('data/db.users.json');
		if ($this->db->isValid())
			$this->users = Json::decode($this->db->read());
	}

	/**
	 * Saves current data to file
	 *
	 * @return void
	 */
	protected function storeData(): void {
		if ($this->db->isValid())
			$this->db->write(Json::encode($this->users));
	}

	/**
	 * Fetch user by id
	 *
	 * status
	 * 200 - user found
	 * 404 - user not found
	 * 400 - invalid id (string or negative)
	 *
	 * @param   int  $id    user id
	 *
	 * @return array    matching user
	 */
	protected function find(int $id): ?array {
		return array_find($this->users, fn($u) => $u['id'] == $id);
	}

	/**
	 * Fetch user by id
	 *
	 * status
	 * 200 - user found
	 * 404 - user not found
	 * 400 - invalid id (string or negative)
	 *
	 * @param   int  $id    user id
	 *
	 * @return array    matching user
	 */
	protected function filter(array $data, string $field, int|string $search): ?array {
		return array_values(array_filter($data, fn($u) => levenshtein(\strval($u[$field]), $search) <= 3));
	}

	/**
	 * Generate new id
	 *
	 * @return int    new id
	 */
	protected function newId(): int {
		return array_reduce($this->users, fn($carry, $u) => $u['id'] > $carry ? $u['id'] : $carry, 0) + 1;
	}

	#[Route(path: '/api/users/{id<\d+>}', name: 'users-action')]
	// #[Route(path: '/api/users', name: 'users')]
	public function rest(array $args = []): array|ModelInterface {
		dd($args, 'args');
		return [];
	}

	/**
	 * Get list of users
	 *
	 * status
	 * 200 - user list
	 *
	 * @return array|ModelInterface    users list
	 */
	public function list(): array|ModelInterface {
		if (array_key_exists('query-string', $this->routeMatch->params)) {
			$query = $this->routeMatch->params['query-string'];
			$users = $this->users;
			foreach ($query as $k => $v)
				$users = $this->filter($users, $k, $v);

			return new JsonModel($users);
		}
		return new JsonModel($this->users);
	}

	/**
	 * Get user by id
	 *
	 * status
	 *  200 - user found
	 *  404 - user not found
	 *  400 - invalid id (string or negative)
	 *
	 * @param   array  $args
	 *
	 * @return array|ModelInterface    a user
	 */
	public function get(array $args): array|ModelInterface {
		if (is_numeric($args['id']) == false || intval($args['id']) <= 0) {
			return new JsonModel($args['id'], [
				'status' => 400,
			]);
		}

		$user = $this->find(intval($args['id']));
		if ($user == null) {
			return new JsonModel($args['id'], [
				'status' => 404,
			]);
		}

		return new JsonModel($user);
	}

	/**
	 * Create a new user
	 *
	 * status
	 * 201 - user created (return data & location header)
	 * 200 - user created(user created but no data returned)
	 * 204 - no data (user created but no data returned)
	 *
	 * @return array|ModelInterface    new user
	 */
	public function create(): array|ModelInterface {
		$user = array_intersect_key($this->request->getPost()->toArray(), static::$template);
		$user['id'] = $this->newId();

		if (count($user) < count(static::$template)) {
			return new JsonModel($user, [
				'status' => 401,
			]);
		}

		$this->users = array_merge($this->users, [$user]);
		$this->storeData();

		return new JsonModel($user, [
			'status' => 201,
			'headers' => [
				'Location' => '/api/user/' . $user['id'],
			],
		]);
	}

	/**
	 * Update user properties
	 *
	 * status
	 * 200 - user updated(user updated but no data returned)
	 * 204 - no data (user updated but no data returned)
	 * 201 - user created (return data & location header - if api supports creation via put)
	 *
	 * @param   array  $args
	 *
	 * @return array|ModelInterface    updated user
	 */
	public function update(array $args): array|ModelInterface {
		if ($this->find(intval($args['id'])) == null) {
			return new JsonModel($args['id'], [
				'status' => 404,
			]);
		}
		foreach ($this->users as $index => $user) {
			if ($user['id'] == $args['id']) {
				foreach ($this->request->getPost()->toArray() as $k => $v)
					if ($k != 'id') $user[$k] = $v;
				$this->users[$index] = $user;
				break;
			}
		}

		$this->storeData();

		return new JsonModel($user, [
			'status' => 201,
		]);
	}

	/**
	 * Delete a user
	 *
	 * status
	 * 200 - user deleted (return id)
	 * 202 - user queued for delete
	 * 204 - no data (user deleted but no data returned)
	 * 404 - user not found
	 *
	 * @param   array  $args
	 *
	 * @return array|ModelInterface    updated user list
	 */
	public function delete(array $args): array|ModelInterface {
		if ($this->find(intval($args['id'])) == null) {
			return new JsonModel(['id' => $args['id']], [
				'status' => 404,
			]);
		}

		$this->users = array_values(array_filter($this->users, fn($u) => $u['id'] != $args['id']));
		$this->storeData();

		return new JsonModel(['id' => $args['id']]);
	}
}
