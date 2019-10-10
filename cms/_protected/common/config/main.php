<?php
return [
    'name' => 'Duy Tân Computer',
    'language' => 'vi',
    'timeZone' => 'Asia/Ho_Chi_Minh',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'assetManager' => [
            'bundles' => [
                // we will use bootstrap css from our theme
                // 'yii\bootstrap\BootstrapAsset' => [
                //     'css' => [], // do not use yii default one
                // ],
            ],
        ],
        // 'cache' => [
        //     'class' => 'yii\caching\FileCache',
        // ],
        'session' => [
            'class' => 'yii\web\DbSession',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/translations',
                    'sourceLanguage' => 'en',
                ],
                'yii' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/translations',
                    'sourceLanguage' => 'en'
                ],
            ],
        ],
    ], // components
];
