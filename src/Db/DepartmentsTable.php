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

use Inane\Db\Table\AbstractTable;

/**
 * DepartmentsTable
 *
 * @method false|Department fetch(string|int|float $id)
 * @method Department[] fetchAll()
 * @method Department[] search(array|string $query)
 * @method Department insert(Department $entity)
 * @method Department update(Department $entity)
 * @method bool delete(Department $entity)
 */
class DepartmentsTable extends AbstractTable {
    protected string $table = 'departments';
    protected string $primaryId = 'id';
    protected string $entityClass = Department::class;
}
