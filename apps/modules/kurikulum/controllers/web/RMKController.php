<?php

namespace Siakad\Kurikulum\Controllers\Web;

use Exception;
use InvalidArgumentException;
use Phalcon\Mvc\Controller;
use Siakad\Kurikulum\Application\KelolaRMKRequest;
use Siakad\Kurikulum\Application\LihatFormRMKRequest;
use Siakad\Kurikulum\Application\UserNotFoundException;
use Siakad\Kurikulum\Controllers\Validators\RMKValidator;

class RMKController extends Controller
{
    private $daftarRMKService;
    private $formRMKService;
    private $kelolaRMKService;
    
    public function initialize()
    {
        $this->daftarRMKService = $this->di->get('daftar_rmk_service');
        $this->formRMKService = $this->di->get('form_rmk_service');
        $this->kelolaRMKService = $this->di->get('kelola_rmk_service');
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
            $this->handleFormRMK();
        }
        $this->handleAddGet();
    }

    public function editAction()
    {
        if ($this->request->isPost()) {
            $this->handleFormRMK();
        }
        $this->handleEditGet();
    }

    private function handleAddGet()
    {
        $service = $this->formRMKService;
        $response = $service->execute(
            new LihatFormRMKRequest()
        );
        
        $this->view->rmk = $response->rmk;
        $this->view->listUser = $response->listUser;
        $this->view->action = 'rmk/add';
        return $this->view->pick('rmk/form');
    }

    private function handleFormRMK()
    {
        $validator = new RMKValidator();
        $messages = $validator->validate($_POST);
        if (count($messages)) {
            foreach ($messages as $message) {
                $this->flashSession->error($message->getMessage());
            }
            return $this->view->pick('rmk/form');        
        }
        
        $id = $this->request->getPost('id') ?: null;
        $request = new KelolaRMKRequest(
            $this->request->getPost('kode_rmk'),
            $this->request->getPost('nama_indonesia'),
            $this->request->getPost('nama_inggris'),
            $this->request->getPost('ketua_identifier'),
            $id
        );
        $service = $this->kelolaRMKService;
        try {
            $service->execute($request);
            $this->flashSession->success('Berhasil menyimpan RMK');
        } catch (InvalidArgumentException $e) {
            $this->flashSession->error($e->getMessage());
        } catch (UserNotFoundException $e) {
            $this->flashSession->error($e->getMessage());
        } catch (Exception $e) {
            $this->flashSession->error('Internal Server Error');
        }
        return $this->view->pick('rmk/form');
    }

    private function handleEditGet()
    {
        $id = $this->dispatcher->getParam('id');
        $service = $this->formRMKService;
        $response = $service->execute(
            new LihatFormRMKRequest($id)
        );

        $this->view->rmk = $response->rmk;
        $this->view->listUser = $response->listUser;
        $this->view->action = "rmk/{$id}/edit";
        return $this->view->pick('rmk/form');
    }

}