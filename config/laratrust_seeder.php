<?php

return [
    'roles_structure' => [
        'super_admin' => [
            'patients' => 'c,r,u,d',
            'results' => 'c,r,u,d',
            'categories' => 'c,r,u,d',
            'tests' => 'c,r,u,d',
            'insurances' => 'c,r,u,d',
            'employees' => 'c,r,u,d',
            'expenses' => 'c,r,u,d',
            'visits' => 'c,r,u,d',
            'users' => 'c,r,u,d',
            'reports' => 'c,r,u,d',
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
