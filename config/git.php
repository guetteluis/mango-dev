<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Repositories
    |--------------------------------------------------------------------------
    |
    | Stores all the valid repository names
    |
    */

    'repositories' => [
        'public' => [
            'ma-core-public',
            'ma-modules-public',
            'ma-dashboards',
        ],
        'private' => [
            'ma-modules-private',
            'ma-modules-proprietary',
            'dashboards'
        ]
    ],

];
