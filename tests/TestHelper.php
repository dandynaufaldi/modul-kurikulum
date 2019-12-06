<?php 

use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;

ini_set("display_errors", 1);
error_reporting(E_ALL);

define("ROOT_PATH", __DIR__);
define("APP_PATH", ROOT_PATH . '/../apps');

// Required for phalcon/incubator
include __DIR__ . "/../vendor/autoload.php";

// Use the application autoloader to autoload the classes
// Autoload the dependencies found in composer
$loader = new Loader();

$loader->registerNamespaces([
    'Siakad\Kurikulum\Domain\Model' => APP_PATH . '/modules/kurikulum/domain/model',
    'Siakad\Kurikulum\Infrastructure' => APP_PATH . '/modules/kurikulum/infrastructure',
    'Siakad\Kurikulum\Application' => APP_PATH . '/modules/kurikulum/application',
]);

$loader->register();

$di = new FactoryDefault();

Di::reset();

// Add any needed services to the DI here

Di::setDefault($di);