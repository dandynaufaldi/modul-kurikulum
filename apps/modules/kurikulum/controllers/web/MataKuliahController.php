<?php

namespace Siakad\Kurikulum\Controllers\Web;

use Exception;
use InvalidArgumentException;
use Phalcon\Mvc\Controller;
use Siakad\Kurikulum\Application\HapusKurikulumRequest;
use Siakad\Kurikulum\Application\HapusMataKuliahRequest;
use Siakad\Kurikulum\Application\KelolaKurikulumRequest;
use Siakad\Kurikulum\Application\KelolaMataKuliahRequest;
use Siakad\Kurikulum\Application\KurikulumNotFoundException;
use Siakad\Kurikulum\Application\LihatFormKurikulumRequest;
use Siakad\Kurikulum\Application\LihatFormMataKuliahRequest;
use Siakad\Kurikulum\Application\MataKuliahNotFoundException;
use Siakad\Kurikulum\Application\ProgramStudiNotFoundException;
use Siakad\Kurikulum\Controllers\Validators\KurikulumValidator;
use Siakad\Kurikulum\Controllers\Validators\MataKuliahValidator;
use Siakad\Kurikulum\Domain\Model\UnrecognizedSemesterException;

class MataKuliahController extends Controller
{
    private $daftarMataKuliahService;
    private $formMataKuliahService;
    private $kelolaMataKuliahService;
    private $hapusMataKuliahService;

    public function initialize()
    {
        $this->daftarMataKuliahService = $this->di->get('daftar_mata_kuliah_service');
        $this->formMataKuliahService = $this->di->get('form_mata_kuliah_service');
        $this->kelolaMataKuliahService = $this->di->get('kelola_mata_kuliah_service');
        $this->hapusMataKuliahService = $this->di->get('hapus_mata_kuliah_service');
    }

    public function indexAction()
    {
        $service = $this->daftarMataKuliahService;
        $response = $service->execute();
        $this->view->listMataKuliah = $response->listMataKuliah;
        return $this->view->pick('mata_kuliah/index');
    }
    
    public function addAction()
    {        
        if ($this->request->isPost()) {
            $this->handleFormMataKuliah();
        }
        $this->handleAddGet();
    }

    private function handleAddGet()
    {
        $service = $this->formMataKuliahService;
        $response = $service->execute(
            new LihatFormMataKuliahRequest()
        );

        $this->view->listRmk = $response->listRmk;
        $this->view->mataKuliah = $response->mataKuliah;
        $this->view->action = 'mata-kuliah/add';
        return $this->view->pick('mata_kuliah/form');
    }

    private function handleFormMataKuliah()
    {
        $validator = new MataKuliahValidator();
        $messages = $validator->validate($_POST);
        if (count($messages)) {
            foreach ($messages as $message) {
                $this->flashSession->error($message->getMessage());
            }
            return $this->view->pick('mata_kuliah/form');
        }
        
        $id = $this->request->getPost('id') ?: null;
        $request = new KelolaMataKuliahRequest(
            $this->request->getPost('kode_rmk'),
            $this->request->getPost('kode_mata_kuliah'),
            $this->request->getPost('nama_indonesia'),
            $this->request->getPost('nama_inggris'),
            $this->request->getPost('deskripsi'),
            $id
        );
        $service = $this->kelolaMataKuliahService;

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
            $this->flashSession->error('Internal Server Error ' . $e->getMessage());
        }
        return $this->view->pick('mata_kuliah/form');
    }

    private function handleEditGet()
    {
        $id = $this->dispatcher->getParam('id');
        $request = new LihatFormMataKuliahRequest($id);
        $service = $this->formMataKuliahService;
        $response = $service->execute($request);

        $this->view->listRmk = $response->listRmk;
        $this->view->mataKuliah = $response->mataKuliah;
        $this->view->action = "mata-kuliah/{$id}/edit";
        return $this->view->pick('mata_kuliah/form');
    }

    public function editAction()
    {
        if ($this->request->isPost()) {
            $this->handleFormMataKuliah();
        }
        $this->handleEditGet();
    }

    public function deleteAction()
    {
        $id = $this->request->getPost('id');
        $request = new HapusMataKuliahRequest($id);
        $service = $this->hapusMataKuliahService;
        
        try {
            $service->execute($request);
            $this->flashSession->success('Berhasil menghapus mata kuliah');
        } catch (MataKuliahNotFoundException $e) {
            $this->flashSession->error($e->getMessage());
        } catch (Exception $e) {
            $this->flashSession->error('Internal Server Error');
        }

        return $this->response->redirect('mata-kuliah');
    }

}