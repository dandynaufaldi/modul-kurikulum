<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\KurikulumRepository;

class KelolaMataKuliahKurikulumService
{
    private $kurikulumRepository;

    /**
     * KelolaMataKuliahKurikulumService constructor.
     * @param $kurikulumRepository
     */
    public function __construct(KurikulumRepository $kurikulumRepository)
    {
        $this->kurikulumRepository = $kurikulumRepository;
    }

    public function execute(KelolaMataKuliahKurikulumRequest $request)
    {
        $kurikulum = $this->kurikulumRepository->byId($request->kurikulumId);
        if(empty($kurikulum)) {
            throw new KurikulumNotFoundException("Kurikulum  {$request->kurikulumId->id()} tidak dapat ditemukan");
        }

        $mataKuliah = $this->kurikulumRepository->fetchMataKuliahById($kurikulum->getId(), $request->mataKuliahId);
        if(empty($mataKuliah)) {
            // TODO create Matkul?
        } else {
            // TODO edit matkul?
        }

        $kurikulum->kelolaMataKuliah($mataKuliah);

        $this->kurikulumRepository->save($kurikulum);
    }


}