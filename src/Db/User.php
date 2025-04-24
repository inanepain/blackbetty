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

namespace Dev\Db;

use Inane\Db\Entity\AbstractEntity;

/**
 * User
 */
class User extends AbstractEntity {
    protected string $dataTableClass = UsersTable::class;

    /**
     * @var array An array to hold torrent properties.
     */
    protected array $data = [
        'id' => null,
        'iddepartment' => 1,
        'name' => '',
        'email' => '',
        'group' => '',
    ];

    /**
     * @var int|null The id of the user.
     */
    public int|null $id {
        get => $this->data['id'];
        set(int|null $value) {
            $this->data['id'] = $value;
        }
    }

    /**
     * @var int The id of the department.
     */
    public int $iddepartment {
        get => $this->data['iddepartment'];
        set(int $value) {
            $this->data['iddepartment'] = $value;
        }
    }

    /**
     * @var Department The department associated with the user.
     */
    public Department $department {
        get {
            $d = new Department();
            $d->fetch($this->iddepartment);
            return $d;
        }
        set(Department $value) {
            $this->data['iddepartment'] = $value->id;
        }
    }

    /**
     * @var string The name of the user.
     */
    public string $name {
        get => $this->data['name'];
        set(string $value) {
            $this->data['name'] = $value;
        }
    }

    /**
     * @var string The email of the user.
     */
    public string $email {
        get => $this->data['email'];
        set(string $value) {
            $this->data['email'] = $value;
        }
    }

    /**
     * @var string The group of the user.
     */
    public string $group {
        get => $this->data['group'];
        set(string $value) {
            $this->data['group'] = $value;
        }
    }
}
