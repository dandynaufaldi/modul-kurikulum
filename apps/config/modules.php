<?php

return array(
    'kurikulum' => [
        'namespace' => 'Kur\Kurikulum',
        'webControllerNamespace' => 'Kur\Kurikulum\Controllers\Web',
        'apiControllerNamespace' => 'Kur\Kurikulum\Controllers\Api',
        'className' => 'Kur\Kurikulum\Module',
        'path' => APP_PATH . '/modules/kurikulum/Module.php',
        'defaultRouting' => true,
        'defaultController' => 'idea',
        'defaultAction' => 'index'
    ],

);