<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\RMKRepository;

class LihatDaftarRMKService
{
    private $RMKRepository;

    public function __construct(RMKRepository $RMKRepository)
    {
        $this->RMKRepository = $RMKRepository;
    }

    public function execute()
    {
        $listRMK = $this->RMKRepository->all();

        $response = new LihatDaftarRMKResponse();

        if ($listRMK) {
            foreach ($listRMK as $row) {
                $response->addRMKResponse(
                    $row->id()->id(),
                    $row->kode(),
                    $row->nama()->indonesia(),
                    $row->ketua()->name(),
                );
            }
        }
        return $response;
    }
}