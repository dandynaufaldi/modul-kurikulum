<?php

namespace Siakad\Kurikulum;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([
            'Siakad\Kurikulum\Domain\Model' => __DIR__ . '/domain/model',
            'Siakad\Kurikulum\Infrastructure' => __DIR__ . '/infrastructure',
            'Siakad\Kurikulum\Application' => __DIR__ . '/application',
            'Siakad\Kurikulum\Controllers\Web' => __DIR__ . '/controllers/web',
            'Siakad\Kurikulum\Controllers\Api' => __DIR__ . '/controllers/api',
            'Siakad\Kurikulum\Controllers\Validators' => __DIR__ . '/controllers/validators',
        ]);

        $loader->register();
    }

    public function registerServices(DiInterface $di = null)
    {
        $moduleConfig = require __DIR__ . '/config/config.php';

        $di->get('config')->merge($moduleConfig);

        include_once __DIR__ . '/config/services.php';
    }

}