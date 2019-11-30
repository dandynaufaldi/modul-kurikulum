<?php

namespace Kur\Kurikulum;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([
            'Kur\Kurikulum\Domain\Model' => __DIR__ . '/domain/model',
            'Kur\Kurikulum\Infrastructure' => __DIR__ . '/infrastructure',
            'Kur\Kurikulum\Application' => __DIR__ . '/application',
            'Kur\Kurikulum\Controllers\Web' => __DIR__ . '/controllers/web',
            'Kur\Kurikulum\Controllers\Api' => __DIR__ . '/controllers/api',
            'Kur\Kurikulum\Controllers\Validators' => __DIR__ . '/controllers/validators',
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