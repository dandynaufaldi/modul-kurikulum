<?php


namespace Siakad\Kurikulum\Application;


use Siakad\Kurikulum\Domain\Model\KurikulumRepository;
use Siakad\Kurikulum\Domain\Model\MataKuliahRepository;

class HapusMataKuliahKurikulumService
{
    private $kurikulumRepository;
    private $mataKuliahRepository;

    /**
     * HapusMataKuliahKurikulumService constructor.
     * @param $kurikulumRepository
     * @param $mataKuliahRepository
     */
    public function __construct(
        KurikulumRepository $kurikulumRepository,
        MataKuliahRepository $mataKuliahRepository
    )
    {
        $this->kurikulumRepository = $kurikulumRepository;
        $this->mataKuliahRepository = $mataKuliahRepository;
    }


    public function execute(HapusMataKuliahKurikulumRequest $request)
    {
        $kurikulum = $this->kurikulumRepository->byId($request->kurikulumId);
        if(empty($kurikulum)) {
            throw new KurikulumNotFoundException("Kurikulum {$request->kurikulumId->id()} tidak dapat ditemukan");
        }

        $mataKuliah = $this->mataKuliahRepository->byId($request->mataKuliahId);
        if(empty($mataKuliah)) {
            throw new MataKuliahNotFoundException("Matakuliah {$request->mataKuliahId->id()} tidak dapat ditemukan");
        }

        $kurikulum->hapusMataKuliah($mataKuliah);
        $this->kurikulumRepository->save($kurikulum);
    }


}