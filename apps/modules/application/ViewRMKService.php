<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\RMKRepository;

class ViewRMKService
{
    private $RMKRepository;

    public function __construct(
        RMKRepository $RMKRepository
    )
    {
        $this->RMKRepository = $RMKRepository;
    }

    public function execute()
    {
        $listRMK = $this->RMKRepository->all();

        $response = new ViewRMKResponse();

        if ($listRMK) {
            foreach ($listRMK as $row) {
                $response->addRMKResponse(
                    $row->kode(),
                    $row->name(),
                    $row->user()->name(),
                );
            }
        }
        return $response;
    }
}