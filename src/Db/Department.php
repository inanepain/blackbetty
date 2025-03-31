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

use Cathedral\Db\AbstractEntity;

/**
 * Department
 */
class Department extends AbstractEntity {
    protected string $dataTableClass = DepartmentsTable::class;

    /**
     * @var array An array to hold torrent properties.
     */
    protected array $data = [
        'id' => null,
        'name' => '',
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
     * @var string The name of the user.
     */
    public string $name {
        get => $this->data['name'];
        set(string $value) {
            $this->data['name'] = $value;
        }
    }
}
