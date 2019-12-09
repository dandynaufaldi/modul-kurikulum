<?php

namespace Siakad\Kurikulum\Controllers\Web;

use Phalcon\Mvc\Controller;
use Siakad\Kurikulum\Application\LihatDaftarKurikulumService;
use Siakad\Kurikulum\Application\LihatFormKurikulumRequest;
use Siakad\Kurikulum\Application\LihatFormKurikulumService;

class KurikulumController extends Controller
{
    public function initialize()
    {
        
    }

    public function indexAction()
    {
        $kurikulumRepository = $this->di->get('sql_kurikulum_repository');
        $service = new LihatDaftarKurikulumService($kurikulumRepository);
        $response = $service->execute();
        // dd($response->listKurikulum);
        $this->view->listKurikulum = $response->listKurikulum;
        return $this->view->pick('kurikulum/index');
    }
    
    public function addAction()
    {
        $kurikulumRepository = $this->di->get('sql_kurikulum_repository');
        $programStudiRepository = $this->di->get('sql_prodi_repository');
        
        $service = new LihatFormKurikulumService(
            $kurikulumRepository,
            $programStudiRepository
        );
        $response = $service->execute(
            new LihatFormKurikulumRequest()
        );

        dd($response);
    }

    public function editAction()
    {
        $kurikulumRepository = $this->di->get('sql_kurikulum_repository');
        $programStudiRepository = $this->di->get('sql_prodi_repository');
        
        $id = $this->dispatcher->getParam('id');
        $request = new LihatFormKurikulumRequest($id);
        $service = new LihatFormKurikulumService(
            $kurikulumRepository,
            $programStudiRepository
        );
        $response = $service->execute($request);
        dd($response);
    }

}