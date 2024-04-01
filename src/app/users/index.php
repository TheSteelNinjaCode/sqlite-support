<?php

use Lib\Prisma\Classes\Prisma;

$prisma = new Prisma();

// $prisma->user->create([
//     'data' => [
//         'name' => 'Reinaldo Salgado',
//         'email' => 'reinaldo@example.com',
//         'age' => 30
//     ]
// ]);

// $prisma->user->update([
//     'where' => [
//         'id' => 'nGXBOIP4v8xgy7YNw1CwC'
//     ],
//     'data' => [
//         'age' => 22
//     ]
// ]);

// $prisma->user->delete([
//     'where' => [
//         'id' => 'AdqyZRlwIf6Fifx2ewFTu'
//     ]
// ]);

$users = $prisma->user->findMany();

echo "<pre>";
print_r($users);
echo "</pre>";

// Review Mode
// Support for '_avg', '_count', '_max', '_min', '_sum',
$aggregate = $prisma->user->aggregate([
    '_sum' => [
        'age' => true
    ],
    // not supported yet
    '_avg' => [
        'age' => true
    ],
]);

echo "<pre>";
print_r($aggregate);
echo "</pre>";
