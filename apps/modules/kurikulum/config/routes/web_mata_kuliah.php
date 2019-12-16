<?php

$namespace = 'Siakad\Kurikulum\Controllers\Web';

$router->addGet('/mata-kuliah', [
    'namespace' => $namespace,
    'module' => 'kurikulum',
    'controller' => 'mataKuliah',
    'action' => 'index'
]);

$router->add('/mata-kuliah/add', [
    'namespace' => $namespace,
    'module' => 'kurikulum',
    'controller' => 'mataKuliah',
    'action' => 'add'
]);

$router->add('/mata-kuliah/{id}/edit', [
    'namespace' => $namespace,
    'module' => 'kurikulum',
    'controller' => 'mataKuliah',
    'action' => 'edit'
]);

$router->addPost('/mata-kuliah/{id}/delete', [
    'namespace' => $namespace,
    'module' => 'kurikulum',
    'controller' => 'mataKuliah',
    'action' => 'delete'
]);