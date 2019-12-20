<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\KurikulumRepository;

class LihatFormMataKuliahKurikulumService
{
    private $kurikulumRepository;

    public function __construct(KurikulumRepository $kurikulumRepository)
    {
        $this->kurikulumRepository = $kurikulumRepository;
    }

    public function execute(LihatFormMataKuliahKurikulumRequest $request)
    {
        if (empty($request->mataKuliahId)) {
            return new LihatFormMataKuliahKurikulumResponse($request->kurikulumId);
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