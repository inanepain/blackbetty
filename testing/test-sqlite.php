<?php

/**
 * This file is used to run the tests in an IDE.
 *
 * These test files are generally unsaved files that are not part of the project. Typically used for a quick test and thrown away.
 *
 * https://developer.okta.com/blog/2019/03/08/simple-rest-api-php
 *
 * @version 0.1.0
 */

declare(strict_types=1);

chdir('C:\www\develop');

include __DIR__ . '/vendor/autoload.php';

$db = new \PDO('sqlite:data/develop.db');

// $stmt = $db->prepare('INSERT INTO users(name,email) VALUES(:name,:email)');
// $stmt->execute([
//     ':name' => 'Inane',
//     ':email'  => 'pain@develop',
// ]);

$sql = "SELECT * FROM person";

$result = $db->prepare('SELECT * FROM users');
$result->execute();
$users = $result->fetchALL(PDO::FETCH_ASSOC);

if($users) {
    foreach($users as $user) {
        print $user['name'] . ' ' . $user['email'] . PHP_EOL;
    }
}