<?php

return [
    'roles_structure' => [
        'super_admin' => [
            'patients' => 'c,r,u,d',
            'categories' => 'c,r,u,d',
            'analyses' => 'c,r,u,d',
            'sub_analyses' => 'c,r,u,d',
            'insurances' => 'c,r,u,d',
            'visits' => 'c,r,u,d',
            'users' => 'c,r,u,d',
        ],
        'user' => []
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
