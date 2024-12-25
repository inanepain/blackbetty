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

namespace Dev\Rest;

use Dev\App\AbstractRestController;
use Inane\File\File;
use Inane\Http\HttpMethod;
use Inane\Routing\Route;
use Inane\Stdlib\Json;

class UserController extends AbstractRestController {
	private File $db;

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
		if ($this->db->isValid()) {
			$this->db->write(Json::encode($this->users));
		}
	}

	/**
	 * Fetch user by id
	 *
	 * @param   int  $id    user id
	 *
	 * @return array    matching user
	 */
	protected function find(int $id): ?array {
		return array_find($this->users, fn($u) => $u['id'] == $id);

	}

	/**
	 * Get list of users
	 *
	 * @return array    users list
	 */
	#[Route(path: '/api/user', name: 'user-list', methods: [HttpMethod::Get])]
	public function list(): array {
		return $this->createMessage(message: 'User List', vars: ['raw' => true]);
	}

	/**
	 * Get user by id
	 *
	 * @param   array  $args
	 *
	 * @return array    a user
	 */
	#[Route(path: '/api/user/{id<\d+>}', name: 'user-get', methods: [HttpMethod::Get])]
	public function get(array $args): array {
		$user = $this->find(intval($args['id']));
		return $this->createMessage(message: $user != null ? 'User Found' : 'User Not Found', data: $user, success: $user != null, vars: ['raw' => true]);
	}

	/**
	 * Create a new user
	 *
	 * @return array    new user list
	 */
	#[Route(path: '/api/user', name: 'user-create', methods: [HttpMethod::Post])]
	public function create(): array {
		$this->users = array_merge($this->users, [$this->request->getPost()->toArray()]);
		$this->storeData();
		return $this->createMessage(message: 'User List: Updated', vars: ['raw' => true]);
		return $this->users + ['raw' => true];
	}

	/**
	 * Update user properties
	 *
	 * @param   array  $args
	 *
	 * @return array    updated user
	 */
	#[Route(path: '/api/user/{id<\d+>}', name: 'user-update', methods: [HttpMethod::Put])]
	public function update(array $args): array {
		foreach($this->users as $index => $user) {
			if ($user['id'] == $args['id']) {
				foreach ($this->request->getPost()->toArray() as $k => $v)
					if ($k != 'id') $user[$k] = $v;
				$this->users[$index] = $user;
			}
		}

		$this->storeData();

		return $this->createMessage(message: 'User Updated', data: $this->find(intval($args['id'])), vars: ['raw' => true]);
	}

	/**
	 * Delete a user
	 *
	 * @param   array  $args
	 *
	 * @return array    updated user list
	 */
	#[Route(path: '/api/user/{id<\d+>}', name: 'user-delete', methods: [HttpMethod::Delete])]
	public function delete(array $args): array {
		$this->users = array_values(array_filter($this->users, fn($u) => $u['id'] != $args['id']));
		$this->storeData();

		return $this->createMessage(message: 'User Deleted', data: ['deleted' => true, 'id' => $args['id']], vars: ['raw' => true]);
	}
}