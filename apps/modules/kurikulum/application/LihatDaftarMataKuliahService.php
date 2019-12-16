<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\MataKuliahRepository;

class LihatDaftarMataKuliahService
{
    private $mataKuliahRepository;

    public function __construct(MataKuliahRepository $mataKuliahRepository)
    {
        $this->mataKuliahRepository = $mataKuliahRepository;
    }

    public function execute() : LihatDaftarMataKuliahResponse
    {
        $response = new LihatDaftarMataKuliahResponse();
        $listMataKuliah = $this->mataKuliahRepository->all();

        foreach ($listMataKuliah as $mataKuliah) {
            $response->addMataKuliah($mataKuliah);
        }

        return $response;
    }

}