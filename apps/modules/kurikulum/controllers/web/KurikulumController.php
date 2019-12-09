<?php

namespace Siakad\Kurikulum\Controllers\Web;

use Exception;
use InvalidArgumentException;
use Phalcon\Mvc\Controller;
use Siakad\Kurikulum\Application\HapusKurikulumRequest;
use Siakad\Kurikulum\Application\KelolaKurikulumRequest;
use Siakad\Kurikulum\Application\KurikulumNotFoundException;
use Siakad\Kurikulum\Application\LihatFormKurikulumRequest;
use Siakad\Kurikulum\Application\ProgramStudiNotFoundException;
use Siakad\Kurikulum\Controllers\Validators\KurikulumValidator;
use Siakad\Kurikulum\Domain\Model\UnrecognizedSemesterException;

class KurikulumController extends Controller
{
    private $daftarKurikulumService;
    private $kelolaKurikulumService;
    private $formKurikulumService;
    private $hapusKurikulumService;

    public function initialize()
    {
        $this->daftarKurikulumService = $this->di->get('daftar_kurikulum_service');
        $this->kelolaKurikulumService = $this->di->get('kelola_kurikulum_service');
        $this->formKurikulumService = $this->di->get('form_kurikulum_service');
        $this->hapusKurikulumService = $this->di->get('hapus_kurikulum_service');

    }

    public function indexAction()
    {
        $service = $this->daftarKurikulumService;
        $response = $service->execute();
        $this->view->listKurikulum = $response->listKurikulum;
        return $this->view->pick('kurikulum/index');
    }
    
    public function addAction()
    {        
        if ($this->request->isPost()) {
            $this->handleFormKurikulum();
        }
        $this->handleAddGet();
    }

    private function handleAddGet()
    {
        $service = $this->formKurikulumService;
        $response = $service->execute(
            new LihatFormKurikulumRequest()
        );

        $this->view->listProgramStudi = $response->listProgramStudi;
        $this->view->kurikulum = $response->kurikulum;
        $this->view->action = 'kurikulum/add';
        return $this->view->pick('kurikulum/form');
    }

    private function handleFormKurikulum()
    {
        $validator = new KurikulumValidator();
        $messages = $validator->validate($_POST);
        if (count($messages)) {
            foreach ($messages as $message) {
                $this->flashSession->error($message->getMessage());
            }
            return $this->view->pick('kurikulum/form');        
        }
        
        $id = $this->request->getPost('id') ?: null;
        $request = new KelolaKurikulumRequest(
            $this->request->getPost('prodi'),
            $this->request->getPost('nama_indonesia'),
            $this->request->getPost('nama_inggris'),
            $this->request->getPost('sks_lulus'),
            $this->request->getPost('sks_wajib'),
            $this->request->getPost('sks_pilihan'),
            $this->request->getPost('semester_normal'),
            $this->request->getPost('tahun_mulai'),
            $this->request->getPost('tahun_selesai'),
            $this->request->getPost('semester_mulai'),
            false,
            $id
        );
        $service = $this->kelolaKurikulumService;
        try {
            $service->execute($request);
            $this->flashSession->success('Berhasil menyimpan kurikulum');
        } catch (InvalidArgumentException $e) {
            $this->flashSession->error($e->getMessage());
        } catch (UnrecognizedSemesterException $e) {
            $this->flashSession->error($e->getMessage());
        } catch (ProgramStudiNotFoundException $e) {
            $this->flashSession->error($e->getMessage());
        } catch (Exception $e) {
            $this->flashSession->error('Internal Server Error');
        }
        return $this->view->pick('kurikulum/form');
    }

    private function handleEditGet()
    {
        $id = $this->dispatcher->getParam('id');
        $request = new LihatFormKurikulumRequest($id);
        $service = $this->formKurikulumService;
        $response = $service->execute($request);

        $this->view->listProgramStudi = $response->listProgramStudi;
        $this->view->kurikulum = $response->kurikulum;
        $this->view->action = "kurikulum/{$id}/edit";
        return $this->view->pick('kurikulum/form');
    }

    public function editAction()
    {
        if ($this->request->isPost()) {
            $this->handleFormKurikulum();
        }
        $this->handleEditGet();
    }

    public function deleteAction()
    {
        $id = $this->request->getPost('id');
        $request = new HapusKurikulumRequest($id);
        $service = $this->hapusKurikulumService;
        
        try {
            $service->execute($request);
            $this->flashSession->success('Berhasil menghapus kurikulum');
        } catch (KurikulumNotFoundException $e) {
            $this->flashSession->error($e->getMessage());
        } catch (Exception $e) {
            $this->flashSession->error('Internal Server Error');
        }

        return $this->response->redirect('kurikulum');
    }

}