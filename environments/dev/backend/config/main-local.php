<?php

$config = [
    'language' => 'zh-CN',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ligen@localhost',
            'enableCsrfValidation' => true,
        ],
        'authManager' => [
            //使用数据库操作用户权限
            'class' => 'yii\rbac\DbManager',
        ],
        'assetManager' => [
            //资源管理器能使用符号链接，不用复制文件,默认是关闭的
             'linkAssets' => true,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'transport' => [
                 'class' => 'Swift_SmtpTransport',
                 'host' => 'smtp.163.com',
                 'username' => '15001251815@163.com',
                 'password' => 'lg15001251815',
                 'port' => '25',
                 'encryption' => 'tls',
             ],
             //这句一定有，false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
            'useFileTransport' => false, 
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['trace' ,'error', 'warning' , 'info'],
                ],
                // [
                //     'class' => 'yii\log\EmailTarget',
                //     'mailer' => 'mailer',
                //     'levels' => ['error'],
                //     'message' => [
                //         'from' => ['15001251815@163.com'],
                //         'to' => ['1344372801@qq.com', 'gen.li@aihuishou.com'],
                //         'subject' => 'System Log Message',
                //     ],
                // ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'box' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@backend/language',
                    'sourceLanguage' => 'zh-CN',
                    'fileMap' => [
                        'box' => 'box.php',
                    ],
                ],
            ],
        ],
    ],
    "modules" => [
        'gridview' => [ 
            'class' => '\kartik\grid\Module',
            'i18n'  => [
                'class' => 'yii\i18n\PhpMessageSource',
                //'basePath' => '@kartik/messages',
                //'sourceLanguage' => 'zh',
                'forceTranslation' => true
            ]
        ], 
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',//yii2-admin的导航菜单
            'controllerMap' => [
                 'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'userClassName' => 'mdm\admin\models\User',
                    'idField' => 'id',
                    'usernameField' => 'username',
                ]
            ],
            'menus' => [
                'assignment' => [
                    'label' => '用户授权', // change label
                ],
                'route' => [ 
                    'label' => '路由列表', // disable menu
                ],
            ],
        ],
        'box' => [
            'class' => 'backend\modules\box\Module',
        ],
    ],
    "aliases" => [
        "@mdm/admin" => "@vendor/mdmsoft/yii2-admin",
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            //这里是允许访问的action
            //controller/action
        // * 表示允许所有，后期会介绍这个
            '*'
        ]
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
