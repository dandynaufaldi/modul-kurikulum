<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\KurikulumRepository;

class LihatDaftarMataKuliahKurikulumService
{
    private $kurikulumRepository;

    public function __construct(KurikulumRepository $kurikulumRepository)
    {
        $this->kurikulumRepository = $kurikulumRepository;
    }

    public function execute(LihatDaftarMataKuliahKurikulumRequest $request) : LihatDaftarMataKuliahKurikulumResponse
    {
        $kurikulum = $this->kurikulumRepository->byId($request->id);
        $response = new LihatDaftarMataKuliahKurikulumResponse($kurikulum);
        return $response;
    }
}
