<?php

declare(strict_types=1);

use yii\web\Request;

$projectRoot = dirname(__DIR__);

return [
    'id' => 'yii2-web',
    'basePath' => $projectRoot,
    'vendorPath' => $projectRoot,
    'components' => [
        'urlManager' => [
            'baseUrl' => 'https://yii2-web.com',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'request' => [
            'class' => Request::class,
            'enableCsrfValidation' => false,
            'cookieValidationKey' => 'test',
        ],
    ],
];
