<?php


namespace Siakad\Kurikulum\Application;


use Siakad\Kurikulum\Domain\Model\KurikulumId;
use Siakad\Kurikulum\Domain\Model\KurikulumRepository;
use Siakad\Kurikulum\Domain\Model\MataKuliahRepository;

class TambahMataKuliahService
{
    private $kurikulumRepository;
    private $mataKuliahRepository;

    /**
     * TambahMataKuliahService constructor.
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

    public function execute(TambahMataKuliahRequest $request)
    {
        $kurikulum = $this->kurikulumRepository->byId($request->kurikulumId);
        $mataKuliah = $request->mataKuliah;


    }


}