<?php
/**
 * Pop Web Bootstrap Application Framework side nav configuration
 */
return [
    /**'modules' => [
        'name' => 'Modules',
        'href' => '/modules',
        'acl'  => [
            'resource'   => 'modules',
            'permission' => 'index'
        ],
        'attributes' => [
            'class' => 'modules-nav-icon'
        ]
    ],*/
    'roles' => [
        'name' => 'Roles',
        'href' => '/roles',
        'acl'  => [
            'resource'   => 'roles',
            'permission' => 'indes'
        ],
        'attributes' => [
            'class'      => 'roles-nav-icon'
        ]

    ],
    'sessions' => [
        'name' => 'Sessions',
        'href' => '/sessions',
        'acl'  => [
            'resource'   => 'sessions',
            'permission' => 'index'
        ],
        'attributes' => [
            'class' => 'sessions-nav-icon'
        ],
        'children' => [
            'logins' => [
                'name' => 'Logins',
                'href' => 'logins',
                'acl'  => [
                    'resource'   => 'sessions',
                    'permission' => 'logins'
                ]
            ]
        ]
    ],
    'users' => [
        'name' => 'Users',
        'href' => '/users',
        'acl'  => [
            'resource'   => 'users',
            'permission' => 'index'
        ],
        'attributes' => [
            'class' => 'users-nav-icon'
        ]
    ]
];