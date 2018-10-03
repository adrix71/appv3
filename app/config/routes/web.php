<?php
/**
 * Web Routes
 */
return [
    '/[/]' => [
        'controller' => 'App\Controller\Site\SiteController',
        'action'     => 'index'
    ],
    '/content' => [
        'controller' => 'App\Controller\Site\SiteController',
        'action'     => 'content'
    ],
    '/admin' => [
        'controller' => 'App\Controller\Admin\Dashboard\DashboardController',
        'action'     => 'admin'
    ],
    '/login' => [
        'controller' => 'App\Controller\Admin\Dashboard\DashboardController',
        'action'     => 'login',
        'acl'        => [
            'resource'   => 'login'
        ]
    ],
    '/logout' => [
        'controller' => 'App\Controller\Admin\Dashboard\DashboardController',
        'action'     => 'logout'
    ],
    '/forgot' => [
        'controller' => 'App\Controller\Admin\Dashboard\DashboardController',
        'action'     => 'forgot',
        'acl'        => [
            'resource'   => 'forgot'
        ]
    ],
    '/profile[/]' => [
        'controller' => 'App\Controller\Admin\Dashboard\DashboardController',
        'action'     => 'profile',
        'acl'        => [
            'resource'   => 'profile'
        ]
    ],
    '/verify/:id/:hash' => [
        'controller' => 'App\Controller\Admin\Dashboard\DashboardController',
        'action'     => 'verify'
    ],
    '/users[/:rid]' => [
        'controller' => 'App\Controller\Admin\Users\UsersController',
        'action'     => 'index',
        'acl'        => [
            'resource'   => 'users',
            'permission' => 'index'
        ]
    ],
    '/users/add[/:rid]' => [
        'controller' => 'App\Controller\Admin\Users\UsersController',
        'action'     => 'add',
        'acl'        => [
            'resource'   => 'users',
            'permission' => 'add'
        ]
    ],
    '/users/edit/:id' => [
        'controller' => 'App\Controller\Admin\Users\UsersController',
        'action'     => 'edit',
        'acl'        => [
            'resource'   => 'users',
            'permission' => 'edit'
        ]
    ],
    '/users/process[/]' => [
        'controller' => 'App\Controller\Admin\Users\UsersController',
        'action'     => 'process',
        'acl'        => [
            'resource'   => 'users',
            'permission' => 'process'
        ]
    ],
    '/roles[/]' => [
        'controller' => 'App\Controller\Admin\Roles\RolesController',
        'action'     => 'index',
        'acl'        => [
            'resource'   => 'roles',
            'permission' => 'index'
        ]
    ],
    '/roles/add[/]' => [
        'controller' => 'App\Controller\Admin\Roles\RolesController',
        'action'     => 'add',
        'acl'        => [
            'resource'   => 'roles',
            'permission' => 'add'
        ]
    ],
    '/roles/edit/:id' => [
        'controller' => 'App\Controller\Admin\Roles\RolesController',
        'action'     => 'edit',
        'acl'        => [
            'resource'   => 'roles',
            'permission' => 'edit'
        ]
    ],
    '/roles/json/:id' => [
        'controller' => 'App\Controller\Admin\Roles\RolesController',
        'action'     => 'json'
    ],
    '/roles/remove' => [
        'controller' => 'App\Controller\Admin\Roles\RolesController',
        'action'     => 'remove',
        'acl'        => [
            'resource'   => 'roles',
            'permission' => 'remove'
        ]
    ],
    '/sessions[/]' => [
        'controller' => 'App\Controller\Admin\Sessions\SessionsController',
        'action'     => 'index',
        'acl'        => [
            'resource'   => 'sessions',
            'permission' => 'index'
        ]
    ],
    '/sessions/remove' => [
        'controller' => 'App\Controller\Admin\Sessions\SessionsController',
        'action'     => 'remove',
        'acl'        => [
            'resource'   => 'sessions',
            'permission' => 'remove'
        ]
    ],
    '/sessions/logins' => [
        'controller' => 'App\Controller\Admin\Sessions\SessionsController',
        'action'     => 'logins',
        'acl'        => [
            'resource'   => 'sessions',
            'permission' => 'logins'
        ]
    ],
    '*' => [
        'controller' => 'App\Controller\AbstractController',
        'action'     => 'error'
    ]
];