<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    //require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php'
    //require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'name' => 'ParaSiteDB',
    'basePath' => dirname(__DIR__),
'bootstrap' => ['log','thumbnail'/*,'debug'*/],
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
            'bsVersion' => 3,
            // enter optional module parameters below - only if you need to  
            // use your own export download action or custom translation 
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ],
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['*']
        ]
    ],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
			'enableCookieValidation' => true,
            'enableCsrfValidation' => true,
            'cookieValidationKey' => 'xzj6COJILdhAn6EX4ZPc',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'thumbnail' => [
            'class' => 'himiklab\thumbnail\EasyThumbnail',
            'cacheAlias' => 'assets/gallery_thumbnails',
        ],
        
        
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        
    ],
    
    'params' => $params,
];
