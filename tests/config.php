<?php

declare(strict_types=1);

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
    ],
];
