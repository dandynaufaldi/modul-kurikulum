<?php

return array(
    'kurikulum' => [
        'namespace' => 'Siakad\Kurikulum',
        'webControllerNamespace' => 'Siakad\Kurikulum\Controllers\Web',
        'apiControllerNamespace' => 'Siakad\Kurikulum\Controllers\Api',
        'className' => 'Siakad\Kurikulum\Module',
        'path' => APP_PATH . '/modules/kurikulum/Module.php',
        'defaultRouting' => false,
        'defaultController' => 'index',
        'defaultAction' => 'index'
    ],

);