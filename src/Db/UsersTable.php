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

use Cathedral\Db\AbstractTable;

/**
 * UsersTable
 *
 * @method false|User fetch(string|int|float $id)
 * @method User[] fetchAll()
 * @method User[] search(array|string $query)
 * @method User insert(User $entity)
 * @method User update(User $entity)
 * @method bool delete(User $entity)
 */
class UsersTable extends AbstractTable {
    protected string $table = 'users';
    protected string $primaryId = 'id';
    protected string $class = User::class;
}
