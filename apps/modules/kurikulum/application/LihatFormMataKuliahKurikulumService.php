<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\KurikulumRepository;
use Siakad\Kurikulum\Domain\Model\RMKRepository;

class LihatFormMataKuliahKurikulumService
{
    private $kurikulumRepository;
    private $rmkRepository;

    public function __construct(
        KurikulumRepository $kurikulumRepository,
        RMKRepository $rmkRepository
    )
    {
        $this->kurikulumRepository = $kurikulumRepository;
        $this->rmkRepository = $rmkRepository;
    }

    public function execute(LihatFormMataKuliahKurikulumRequest $request)
    {
        if (empty($request->mataKuliahId)) {
            $listRmk = $this->rmkRepository->all();
            $response = new LihatFormMataKuliahKurikulumResponse($request->kurikulumId);
            foreach ($listRmk as $rmk) {
                $response->addRMK($rmk);
            }
            return $response;
        }
        $mataKuliah = $this->kurikulumRepository->fetchMataKuliahById(
            $request->kurikulumId,
            $request->mataKuliahId
        );
        if (empty($mataKuliah)) {
            throw new MataKuliahNotFoundException(
                "MataKuliah {$request->mataKuliahId} tidak ada di kurikulum {$request->kurikulumId}"
            );
        }
        return new LihatFormMataKuliahKurikulumResponse(
            $request->kurikulumId,
            $mataKuliah
        );
    }
}