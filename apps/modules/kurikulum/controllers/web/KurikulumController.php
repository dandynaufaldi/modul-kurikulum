<?php

namespace Siakad\Kurikulum\Controllers\Web;

use Exception;
use InvalidArgumentException;
use Phalcon\Mvc\Controller;
use Siakad\Kurikulum\Application\HapusKurikulumRequest;
use Siakad\Kurikulum\Application\HapusMataKuliahKurikulumRequest;
use Siakad\Kurikulum\Application\KelolaKurikulumRequest;
use Siakad\Kurikulum\Application\KelolaMataKuliahKurikulumRequest;
use Siakad\Kurikulum\Application\KurikulumNotFoundException;
use Siakad\Kurikulum\Application\LihatDaftarMataKuliahKurikulumRequest;
use Siakad\Kurikulum\Application\LihatFormKurikulumRequest;
use Siakad\Kurikulum\Application\LihatFormMataKuliahKurikulumRequest;
use Siakad\Kurikulum\Application\MataKuliahNotFoundException;
use Siakad\Kurikulum\Application\ProgramStudiNotFoundException;
use Siakad\Kurikulum\Controllers\Validators\KurikulumValidator;
use Siakad\Kurikulum\Domain\Model\UnrecognizedSemesterException;

class KurikulumController extends Controller
{
    private $daftarKurikulumService;
    private $kelolaKurikulumService;
    private $formKurikulumService;
    private $hapusKurikulumService;
    private $daftarMataKuliahKurikulumService;
    private $daftarMataKuliahService;
    private $hapusMataKuliahKurikulumService;
    private $formMataKuliahKurikulumService;
    private $kelolaMataKuliahKurikulumService;

    public function initialize()
    {
        $this->daftarKurikulumService = $this->di->get('daftar_kurikulum_service');
        $this->kelolaKurikulumService = $this->di->get('kelola_kurikulum_service');
        $this->formKurikulumService = $this->di->get('form_kurikulum_service');
        $this->hapusKurikulumService = $this->di->get('hapus_kurikulum_service');
        $this->daftarMataKuliahKurikulumService = $this->di->get('daftar_mk_kurikulum_service');
        $this->daftarMataKuliahService = $this->di->get('daftar_mata_kuliah_service');
        $this->hapusMataKuliahKurikulumService = $this->di->get('hapus_mata_kuliah_kurikulum_service');
        $this->formMataKuliahKurikulumService = $this->di->get('form_mata_kuliah_kurikulum_service');
        $this->kelolaMataKuliahKurikulumService = $this->di->get('kelola_mata_kuliah_kurikulum_service');
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

    public function mataKuliahAction()
    {
        $service = $this->daftarMataKuliahKurikulumService;
        $id = $this->dispatcher->getParam('id');
        $request = new LihatDaftarMataKuliahKurikulumRequest($id);

        $response = $service->execute($request);
        $this->view->kurikulum = $response->kurikulum;
        return $this->view->pick('kurikulum/matakuliah');
    }

    public function addMatakuliahAction()
    {
        $service = $this->daftarMataKuliahService;        
        $response = $service->execute();
        $this->view->listMataKuliah = $response->listMataKuliah;

        $kurikulum_id = $this->dispatcher->getParam('id');
        $this->view->kurikulum_id = $kurikulum_id;

        return $this->view->pick('kurikulum/addmatakuliah');
    }

    public function createMataKuliahAction()
    {
        # TODO: controller untuk membuka form mata kuliah
        if ($this->request->isPost()) {
            $this->handleFormMataKuliahKurikulum();
        }

        $id_kurikulum = $this->dispatcher->getParam('id_kurikulum');
        $request = new LihatFormMataKuliahKurikulumRequest($id_kurikulum);
        $service = $this->formMataKuliahKurikulumService;
        $response = $service->execute($request);
        $this->view->kurikulum_id = $response->kurikulumId;
        $this->view->mataKuliah = $response->mataKuliah;
        $this->view->action = "kurikulum/{$id_kurikulum}/matakuliah/create";
        $this->view->listRmk = $response->listRmk;
        return $this->view->pick('kurikulum/formmatakuliah');
    }

    public  function hapusMataKuliahKurikulumAction()
    {
        $kurikulumId = $this->request->getPost('kurikulum_id');
        $mataKuliahId = $this->request->getPost('matakuliah_id');
        
        $request = new HapusMataKuliahKurikulumRequest($kurikulumId, $mataKuliahId);
        $service = $this->hapusMataKuliahKurikulumService;

        try {
            $service->execute($request);
            $this->flashSession->success('Berhasil menghapus matakuliah dari kurikulum');
        } catch (KurikulumNotFoundException $e) {
            $this->flashSession->error($e->getMessage());
        } catch (MataKuliahNotFoundException $e) {
            $this->flashSession->error($e->getMessage());
        } catch (Exception $e) {
            $this->flashSession->error('Internal server error');
        }
        return $this->response->redirect("kurikulum/{$kurikulumId}/matakuliah");
    }

    public function editMataKuliahAction()
    {
        if ($this->request->isPost()) {
            $this->handleFormMataKuliahKurikulum();
        }
        $id_kurikulum = $this->dispatcher->getParam('id');
        $id_matakuliah = $this->dispatcher->getParam('id_mk');
        $request = new LihatFormMataKuliahKurikulumRequest($id_kurikulum, $id_matakuliah);
        $service = $this->formMataKuliahKurikulumService;
        try {
            $response = $service->execute($request);
            $this->view->mataKuliah = $response->mataKuliah;
            $this->view->kurikulum_id = $response->kurikulumId;
            $this->view->action = "kurikulum/{$id_kurikulum}/matakuliah/edit/{$id_matakuliah}";
            return $this->view->pick('kurikulum/formmatakuliah');
        } catch (MataKuliahNotFoundException $e) {
            $this->flashSession->error($e->getMessage());
        } catch (Exception $e) {
            $this->flashSession->error('Internal server error');
        }
    }

    private function handleFormMataKuliahKurikulum()
    {
        // TODO: MK validator
        
        $request = new KelolaMataKuliahKurikulumRequest(
            $this->request->getPost('kurikulum_id'),
            $this->request->getPost('mata_kuliah_id'),
            $this->request->getPost('kode_rmk'),
            $this->request->getPost('kode_mata_kuliah'),
            $this->request->getPost('nama_indonesia'),
            $this->request->getPost('nama_inggris'),
            $this->request->getPost('deskripsi'),
            $this->request->getPost('sks'),
            $this->request->getPost('sifat'),
            $this->request->getPost('semester')
        );
        $service = $this->kelolaMataKuliahKurikulumService;
        try {
            $service->execute($request);
            $this->flashSession->success('Berhasil menyimpan kurikulum');
        } catch (InvalidArgumentException $e) {
            $this->flashSession->error($e->getMessage());
        } catch (UnrecognizedSemesterException $e) {
            $this->flashSession->error($e->getMessage());
        } catch (Exception $e) {
            $this->flashSession->error($e->getMessage());
        }
        return $this->view->pick('kurikulum/form');
    }
}