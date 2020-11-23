<?php

return [
    'enablePrettyUrl' => true,
    // 'enableStrictParsing' => true,
    'showScriptName' => false,
    'rules' => [
        'blog' => 'site/index',
        'login' => 'site/login',
        'logout' => 'site/logout',
        'forgot-password' => 'site/request-password-reset',
        'reset-password' => 'site/reset-password',
        'User Manual' => 'main/user-manual',
        'Search' => 'main/global-search',
        'About' => 'main/about',

        // Match menu titles and button labels in URL stubs
        '<controller>/New' => '<controller>/create',
        '<controller>/<id:\d+>/View' => '<controller>/view',
        '<controller>/<id:\d+>/Edit' => '<controller>/update',
        // '<controller>/<id:\d+>/Del' => '<controller>/delete',

        'My Account/<id:\w+>' => 'people/update',

        // Prettify document URL here with params etc
        '<controller>/Document' => '<controller>/documents',
        'Report/<controller>' => '<controller>/report-builder',

        // route standard and custom reports
        'query-report/<\w+>' => 'report/query/<\w+>',

        // generic rule goes last
        '<controller>/List' => '<controller>/index',

        'Setup' => 'setup',
        'Setup/<controller>' => 'setup/<controller>/index',

        // REST API rules
        // ['class' => 'yii\rest\UrlRule', 'controller' => 'api/main'],
        // ['class' => 'yii\rest\UrlRule', 'controller' => 'api/user'],
        // ['class' => 'yii\rest\UrlRule', 'controller' => 'api/program'],
        // [
        //     'class' => 'yii\rest\UrlRule',
        //     'controller' => 'api/project',
        //     // 'only' => ['index', 'view'],
        //     // 'except' => ['delete', 'create', 'update'],
        // ],
        // ['class' => 'yii\rest\UrlRule', 'controller' => 'api/indicator'],
        // ['class' => 'yii\rest\UrlRule', 'controller' => 'api/document'],
        // ['class' => 'yii\rest\UrlRule', 'controller' => 'api/projects/activity'],
        // // ['class' => 'yii\rest\UrlRule', 'controller' => 'api/reporting'],
        // // ['class' => 'yii\rest\UrlRule', 'controller' => 'api/learning'],
        // ['class' => 'yii\rest\UrlRule', 'controller' => 'api/partner'],
        // ['class' => 'yii\rest\UrlRule', 'controller' => 'api/people'],
        // ['class' => 'yii\rest\UrlRule', 'controller' => 'api/org'],
        // // ['class' => 'yii\rest\UrlRule', 'controller' => 'api/setup'],
    ],
];
