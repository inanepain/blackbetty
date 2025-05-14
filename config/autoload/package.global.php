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

return [
    'package_library' => [
        'path' => 'lib',
    ],
    'package' => [
        'default' => [
            'name' => '',
            'description' => '',
            'type' => 'library',
            'license' => 'Unlicense',
            'homepage' => '',
            'readme' => 'README.md',
            'keywords' => [
                'php',
                'library',
            ],
            'authors' => [
                [
                    'name' => 'Philip Michael Raab',
                    'email' => 'philip@cathedral.co.za',
                    'role' => 'Developer',
                ],
            ],
            'support' => [
                'email' => 'philip@cathedral.co.za',
                'issues' => '',
            ],
            'config' => [
                'preferred-install' => 'dist',
                'optimize-autoloader' => true,
                'sort-packages' => true,
                'discard-changes' => true,
            ],
            'minimum-stability' => 'dev',
            'autoload' => [],
            'require' => [],
        ],
    ],
];
