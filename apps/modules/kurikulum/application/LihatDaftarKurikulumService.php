<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\KurikulumRepository;

class LihatDaftarKurikulumService
{
    private $kurikulumRepository;

    public function __construct(KurikulumRepository $kurikulumRepository)
    {
        $this->kurikulumRepository = $kurikulumRepository;
    }

    public function execute() : LihatDaftarKurikulumResponse
    {
        $response = new LihatDaftarKurikulumResponse();
        $listKurikulum = $this->kurikulumRepository->all();
        
        foreach ($listKurikulum as $kurikulum) {
            $response->addKurikulum($kurikulum);
        }

        return $response;
    }
}