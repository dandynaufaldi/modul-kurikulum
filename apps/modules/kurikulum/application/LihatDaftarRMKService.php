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

        foreach ($listRMK as $rmk) {
            $response->addRMK($rmk);
        }

        return $response;
    }
}