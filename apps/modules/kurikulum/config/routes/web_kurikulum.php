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

$router->add('/kurikulum/{id}/edit', [
    'namespace' => $namespace,
    'module' => 'kurikulum',
    'controller' => 'kurikulum',
    'action' => 'edit'
]);

$router->addPost('/kurikulum/{id}/delete', [
    'namespace' => $namespace,
    'module' => 'kurikulum',
    'controller' => 'kurikulum',
    'action' => 'delete'
]);

$router->add('/kurikulum/{id}/matakuliah', [
    'namespace' => $namespace,
    'module' => 'kurikulum',
    'controller' => 'kurikulum',
    'action' => 'mataKuliah'
]);

$router->add('/kurikulum/{id}/matakuliah/add', [
    'namespace' => $namespace,
    'module' => 'kurikulum',
    'controller' => 'kurikulum',
    'action' => 'addMataKuliah'
]);

$router->add('/kurikulum/{id_kurikulum}/matakuliah/create', [
    'namespace' => $namespace,
    'module' => 'kurikulum',
    'controller' => 'kurikulum',
    'action' => 'createMataKuliah'
]);

$router->addGet('/rmk', [
    'namespace' => $namespace,
    'module' => 'kurikulum',
    'controller' => 'rmk',
    'action' => 'index'
]);

$router->add('/rmk/add', [
    'namespace' => $namespace,
    'module' => 'kurikulum',
    'controller' => 'rmk',
    'action' => 'add'
]);

$router->add('/rmk/{id}/edit', [
    'namespace' => $namespace,
    'module' => 'kurikulum',
    'controller' => 'rmk',
    'action' => 'edit'
]);

$router->addPost('/rmk/{id}/delete', [
    'namespace' => $namespace,
    'module' => 'kurikulum',
    'controller' => 'rmk',
    'action' => 'delete'
]);