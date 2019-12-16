<?php

namespace Siakad\Kurikulum\Controllers\Web;

use Phalcon\Mvc\Controller;

class RMKController extends Controller
{
    private $daftarRMKService;

    public function initialize()
    {
        $this->daftarRMKService = $this->di->get('daftar_rmk_service');
    }

    public function indexAction()
    {
        $service = $this->daftarRMKService;
        $response = $service->execute();
        $this->view->listRMK = $response->listRMK;
        return $this->view->pick('rmk/index');
    }

    public function addAction()
    {        

    }
}