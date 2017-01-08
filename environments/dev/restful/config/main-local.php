<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '4_JMsoqyyuNifSGPMSky2xO7maVYLKpY',
            'enableCsrfValidation' => false,//post submit don't need Valide
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->data !== null) {
                    $response->data = [
                        'success' => $response->isSuccessful,
                        'data' => $response->data,
                    ];
                    $response->statusCode = 200;
                }
            },
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            //'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => [
                        'module1/default',
                        'module1/store',
                    ],
                    //您可能已经注意到控制器IDuser以复数形式出现在users末端。这是因为 yii\rest\UrlRule 能够为他们使用的末端全自动复数化控制器ID。您可以通过设置 yii\rest\UrlRule::pluralize 为false 来禁用此行为
                    'pluralize' => false,
                    //定义不同的api接口
                    'extraPatterns' => [
                        'GET versions' => 'version',  //对应actionVersion()操作 ../user/versions
                        'GET search/<id:\d+>' => 'search',//对应actionSearch()操作 ../user/search/1
                        'POST newusers' => 'add'  //对应actionAdd()操作 ../user/newusers
                    ],
                ],
            ],
        ],
    ],
    'modules' => [
        'module1' => [
            'class' => 'restful\modules\module1\Module',
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
