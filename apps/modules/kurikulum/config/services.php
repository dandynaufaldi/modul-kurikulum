<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;
use Siakad\Kurikulum\Application\HapusKurikulumService;
use Siakad\Kurikulum\Application\HapusRMKService;
use Siakad\Kurikulum\Application\HapusMataKuliahService;
use Siakad\Kurikulum\Application\KelolaKurikulumService;
use Siakad\Kurikulum\Application\KelolaMataKuliahService;
use Siakad\Kurikulum\Application\KelolaRMKService;
use Siakad\Kurikulum\Application\LihatDaftarKurikulumService;
use Siakad\Kurikulum\Application\LihatDaftarRMKService;
use Siakad\Kurikulum\Application\LihatDaftarMataKuliahService;
use Siakad\Kurikulum\Application\LihatFormKurikulumService;
use Siakad\Kurikulum\Application\LihatFormMataKuliahService;
use Siakad\Kurikulum\Application\LihatFormRMKService;
use Siakad\Kurikulum\Infrastructure\SqlKurikulumRepository;
use Siakad\Kurikulum\Infrastructure\SqlMataKuliahRepository;
use Siakad\Kurikulum\Infrastructure\SqlProgramStudiRepository;
use Siakad\Kurikulum\Infrastructure\SqlRMKRepository;
use Siakad\Kurikulum\Infrastructure\SqlUserRepository;

$di['voltServiceMail'] = function($view) use ($di) {

    $config = $di->get('config');

    $volt = new Volt($view, $di);
    if (!is_dir($config->mail->cacheDir)) {
        mkdir($config->mail->cacheDir);
    }

    $compileAlways = $config->mode == 'DEVELOPMENT' ? true : false;

    $volt->setOptions(array(
        "compiledPath" => $config->mail->cacheDir,
        "compiledExtension" => ".compiled",
        "compileAlways" => $compileAlways
    ));
    return $volt;
};

$di['view'] = function () {
    $view = new View();
    $view->setViewsDir(__DIR__ . '/../views/');

    $view->registerEngines(
        [
            ".volt" => "voltService",
        ]
    );

    return $view;
};

$di['db'] = function () use ($di) {

    $config = $di->get('config');

    $dbAdapter = $config->database->adapter;

    return new $dbAdapter([
        "host" => $config->database->host,
        "username" => $config->database->username,
        "password" => $config->database->password,
        "dbname" => $config->database->dbname
    ]);
};

$di->setShared('sql_kurikulum_repository', function() use ($di) {
    $repo = new SqlKurikulumRepository($di);
    return $repo;
});

$di->setShared('sql_prodi_repository', function() use ($di) {
    $repo = new SqlProgramStudiRepository($di);
    return $repo;
});

$di->setShared('sql_mata_kuliah_repository', function() use ($di) {
    $repo = new SqlMataKuliahRepository($di);
    return $repo;
});

$di->setShared('sql_rmk_repository', function() use ($di) {
    $repo = new SqlRMKRepository($di);
    return $repo;
});

$di->setShared('sql_user_repository', function() use ($di) {
    $repo = new SqlUserRepository($di);
    return $repo;
});

$di->set('daftar_kurikulum_service', function() use ($di) {
    $kurikulumRepository = $di->get('sql_kurikulum_repository');
    return new LihatDaftarKurikulumService(
        $kurikulumRepository
    );
});

$di->set('kelola_kurikulum_service', function() use ($di) {
    $kurikulumRepository = $di->get('sql_kurikulum_repository');
    $programStudiRepository = $di->get('sql_prodi_repository');
    return new KelolaKurikulumService(
        $programStudiRepository,
        $kurikulumRepository
    );
});

$di->set('form_kurikulum_service', function() use ($di) {
    $kurikulumRepository = $di->get('sql_kurikulum_repository');
    $programStudiRepository = $di->get('sql_prodi_repository');
    return new LihatFormKurikulumService(
        $kurikulumRepository,
        $programStudiRepository
    );
});

$di->set('hapus_kurikulum_service', function() use ($di) {
    $kurikulumRepository = $di->get('sql_kurikulum_repository');
    return new HapusKurikulumService(
        $kurikulumRepository
    );
});

$di->set('daftar_rmk_service', function() use ($di) {
    $rmkRepository = $di->get('sql_rmk_repository');
    return new LihatDaftarRMKService(
        $rmkRepository
    );
});

$di->set('form_rmk_service', function() use ($di) {
    $rmkRepository = $di->get('sql_rmk_repository');
    $userRepository = $di->get('sql_user_repository');
    return new LihatFormRMKService(
        $rmkRepository,
        $userRepository
    );
});

$di->set('kelola_rmk_service', function() use ($di) {
    $rmkRepository = $di->get('sql_rmk_repository');
    $userRepository = $di->get('sql_user_repository');
    return new KelolaRMKService(
        $rmkRepository,
        $userRepository
    );
});

$di->set('hapus_rmk_service', function() use ($di) {
    $rmkRepository = $di->get('sql_rmk_repository');
    return new HapusRMKService(
        $rmkRepository
    );
});

$di->set('daftar_mata_kuliah_service', function() use ($di) {
    $mataKuliahRepository = $di->get('sql_mata_kuliah_repository');
    return new LihatDaftarMataKuliahService(
        $mataKuliahRepository
    );
});

$di->set('form_mata_kuliah_service', function() use ($di) {
    $rmkRepository = $di->get('sql_rmk_repository');
    $mataKuliahRepository = $di->get('sql_mata_kuliah_repository');
    return new LihatFormMataKuliahService(
        $rmkRepository,
        $mataKuliahRepository
    );
});

$di->set('kelola_mata_kuliah_service', function() use ($di) {
    $rmkRepository = $di->get('sql_rmk_repository');
    $mataKuliahRepository = $di->get('sql_mata_kuliah_repository');
    return new KelolaMataKuliahService(
        $rmkRepository,
        $mataKuliahRepository
    );
});

$di->set('hapus_mata_kuliah_service', function() use ($di) {
    $mataKuliahRepository = $di->get('sql_mata_kuliah_repository');
    return new HapusMataKuliahService(
        $mataKuliahRepository
    );
});