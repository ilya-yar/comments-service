<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the api
            'name' => 'advanced-api',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'comments',
                    'pluralize' => false,
                    'except' => ['delete'],
                    /* 'extraPatterns' => [
                        'POST' => 'create', // 'xxxxx' refers to 'actionXxxxx'
                        'PUT {id}' => 'update',
                        'PATCH {id}' => 'update',
                        'DELETE {id}' => 'delete',
                        'GET {id}' => 'view',
                        'GET {count}' => 'index',
                    ], */
                ],
            ],
        ],
        /* 'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'urlFormat' => 'path',
            'rules' => [
                'post/<id:\d+>/<title:.*?>'=>'post/view',
                'posts/<tag:.*?>'=>'post/index',
                // REST patterns
                ['api/list', 'pattern'=>'api/<model:\w+>', 'verb'=>'GET'],
                ['api/view', 'pattern'=>'api/<model:\w+>/<id:\d+>', 'verb'=>'GET'],
                ['api/update', 'pattern'=>'api/<model:\w+>/<id:\d+>', 'verb'=>'PUT'],
                ['api/delete', 'pattern'=>'api/<model:\w+>/<id:\d+>', 'verb'=>'DELETE'],
                ['api/create', 'pattern'=>'api/<model:\w+>', 'verb'=>'POST'],
                // Other controllers
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ],
        ], */
    ],
    'params' => $params,
];
