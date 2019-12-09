<?php

$namespace = 'Siakad\Kurikulum\Controllers\Web';

$router->addGet('/kurikulum', [
    'namespace' => $namespace,
    'module' => 'kurikulum',
    'controller' => 'kurikulum',
    'action' => 'index'
]);

$router->add('/kurikulum/add', [
    'namespace' => $namespace,
    'module' => 'kurikulum',
    'controller' => 'kurikulum',
    'action' => 'add'
]);

$router->add('/kurikulum/{id}', [
    'namespace' => $namespace,
    'module' => 'kurikulum',
    'controller' => 'kurikulum',
    'action' => 'edit'
]);