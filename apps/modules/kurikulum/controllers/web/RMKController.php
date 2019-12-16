<?php

namespace Siakad\Kurikulum\Controllers\Web;

use Phalcon\Mvc\Controller;
use Siakad\Kurikulum\Application\LihatFormRMKRequest;

class RMKController extends Controller
{
    private $daftarRMKService;

    public function initialize()
    {
        $this->daftarRMKService = $this->di->get('daftar_rmk_service');
        $this->formRMKService = $this->di->get('form_rmk_service');
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
        if ($this->request->isPost()) {
            // $this->handleFormRMK();
        }
        $this->handleAddGet();
    }

    private function handleAddGet()
    {
        $service = $this->formRMKService;
        $response = $service->execute(
            new LihatFormRMKRequest()
        );
        
        $this->view->rmk = $response->rmk;
        $this->view->listKurikulum = $response->listKurikulum;
        $this->view->listUser = $response->listUser;
        $this->view->action = 'rmk/add';
        return $this->view->pick('rmk/form');
    }
}