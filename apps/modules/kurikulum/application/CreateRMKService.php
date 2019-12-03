<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\RMK;
use Siakad\Kurikulum\Domain\Model\RMKRepository;

class CreateRMKService
{
    private $RMKRepository;

    public function __construct(
        RMKRepository $RMKRepository)
    {
        $this->RMKRepository = $RMKRepository;
    }

    public function execute(CreateNewIdeaRequest $request)
    {
        $RMK = RMK::makeRMK(
            $request->kode,
            $request->name,
            $request->idKetua,
        );

        $this->RMKRepository->save($RMK);
    }
}