<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\RLVDashboardController;
/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

/*
|--------------------------------------------------------------------------
| codigniter
|--------------------------------------------------------------------------
*/



$routes->options('(:any)', static function () {

    $response = service('response');

    return $response

        ->setStatusCode(200)

        ->setHeader(
            'Access-Control-Allow-Origin',
            'http://localhost:8081'
        )

        ->setHeader(
            'Access-Control-Allow-Headers',
            'Origin, X-Requested-With, Content-Type, Accept, Authorization'
        )

        ->setHeader(
            'Access-Control-Allow-Methods',
            'GET, POST, PUT, DELETE, OPTIONS'
        )

        ->setHeader(
            'Access-Control-Allow-Credentials',
            'true'
        );
});


/*
|--------------------------------------------------------------------------
| API ROUTES
|--------------------------------------------------------------------------
*/

$routes->group('api', function($routes) {

    /*
    |--------------------------------------------------------------------------
    | AUTH LOGIN
    |--------------------------------------------------------------------------
    */

    $routes->post(
        'auth/login',
        'RLVAuthController::login'
    );

    $routes->get(
        'auth/profile',
        'RLVAuthController::profile',
        [
            'filter' => 'jwtAuth'
        ]
    );

    /*
    |--------------------------------------------------------------------------
    | AUTH LOGOUT
    |--------------------------------------------------------------------------
    */

    $routes->post(
    'auth/logout',
    'RLVAuthController::logout',
    ['filter' => 'jwtAuth']
);


    /*
    |--------------------------------------------------------------------------
    | ADMIN PANEL
    |--------------------------------------------------------------------------
    */

    $routes->get(
        'admin/panel',
        'RLVAuthController::adminPanel',
        [
            'filter' => [
                'jwtAuth',
                'role:SYS'
            ]
        ]
    );

  /*
    |--------------------------------------------------------------------------
    | DASHBOARD PANEL
    |--------------------------------------------------------------------------
    */


$routes->get(
    'dashboard/stats',
    'RLVDashboardController::stats',
    [
        'filter' => ['jwtAuth']
    ]
);

$routes->get(
    'dashboard/activity',
    'RLVDashboardController::activity',
    [
        'filter' => ['jwtAuth']
    ]
);


    /*
    |--------------------------------------------------------------------------
    | USERS CRUD
    |--------------------------------------------------------------------------
    */

    $routes->group('users', [

        'filter' => [
            'jwtAuth',
            'role:SYS,ADM'
        ]

    ], function($routes) {

        $routes->get(
            '/',
            'RLVUsersController::index'
        );

        $routes->get(
            '(:num)',
            'RLVUsersController::show/$1'
        );

        $routes->post(
            '/',
            'RLVUsersController::create'
        );

        $routes->put(
            '(:num)',
            'RLVUsersController::update/$1'
        );

        $routes->delete(
            '(:num)',
            'RLVUsersController::delete/$1'
        );

    });



     /*
    |--------------------------------------------------------------------------
    | STREETS CRUD
    |--------------------------------------------------------------------------
    */
    $routes->group(
        'streets',
        ['filter' => ['jwtAuth']],
        function($routes) {

            $routes->get('/', 'RLVStreetsController::index');

            $routes->get(
                '(:num)',
                'RLVStreetsController::show/$1'
            );

            $routes->post(
                '/',
                'RLVStreetsController::create'
            );

            $routes->put(
                '(:num)',
                'RLVStreetsController::update/$1'
            );

            $routes->delete(
                '(:num)',
                'RLVStreetsController::delete/$1'
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | RESIDENTS CRUD
    |--------------------------------------------------------------------------
    */

    $routes->group(
        'residents',
        ['filter' => ['jwtAuth']],
        function($routes) {

            $routes->get(
                '/',
                'RLVResidentsController::index'
            );

            $routes->get(
                '(:num)',
                'RLVResidentsController::show/$1'
            );

            $routes->post(
                '/',
                'RLVResidentsController::create'
            );

            $routes->put(
                '(:num)',
                'RLVResidentsController::update/$1'
            );

            $routes->delete(
                '(:num)',
                'RLVResidentsController::delete/$1'
            );

        }
    );



/*
|--------------------------------------------------------------------------
| AUDIT MODULE
|--------------------------------------------------------------------------
*/

$routes->group(
    'audit',
    ['filter' => ['jwtAuth', 'role:SYS']],
    function($routes) {

        $routes->get(
            '/',
            'RLVAuditController::index'
        );

        $routes->get(
            'export',
            'RLVAuditController::export'
        );

        $routes->post(
            'purge',
            'RLVAuditController::purge'
        );
    }
);


/*
|--------------------------------------------------------------------------
| DIRECTORY MODULE
|--------------------------------------------------------------------------
*/

$routes->group(
    'directory',
    ['filter' => ['jwtAuth']],
    function($routes) {

        $routes->get(
            '/',
            'RLVDirectoryController::index'
        );

        $routes->get(
            'export',
            'RLVDirectoryController::export'
        );
    }
);


/*
|--------------------------------------------------------------------------
| ACTIVE USERS MODULE
|--------------------------------------------------------------------------
*/

$routes->group(
    'active-users',
    ['filter' => ['jwtAuth']],
    function ($routes) {

        /**
         * Dashboard realtime
         */
        $routes->get(
            'dashboard',
            'RLVActiveUsersController::dashboard'
        );

        /**
         * Online users
         */
        $routes->get(
            'online',
            'RLVActiveUsersController::onlineUsers'
        );
    }
);


/*
|--------------------------------------------------------------------------
| ROLES
|--------------------------------------------------------------------------
*/

$routes->group(
    'roles',
    ['filter' => ['jwtAuth']],
    function($routes) {

        $routes->get(
            '/',
            'RLVRolesController::index'
        );

        $routes->post(
            '/',
            'RLVRolesController::store'
        );

        $routes->put(
            '(:num)',
            'RLVRolesController::update/$1'
        );

        $routes->delete(
            '(:num)',
            'RLVRolesController::delete/$1'
        );
    }
);

/*
|--------------------------------------------------------------------------
| ActivityTimeline
|--------------------------------------------------------------------------
*/

$routes->get(
    'dashboard/activity-timeline',
    'RLVDashboardController::activityTimeline',
    [
        'filter' => ['jwtAuth']
    ]
);


}

);