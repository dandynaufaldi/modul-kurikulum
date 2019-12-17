<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\RMKRepository;

class HapusRMKService
{
    private $rmkRepository;

    public function __construct(RMKRepository $rmkRepository)
    {
        $this->rmkRepository = $rmkRepository;
    }

    public function execute(HapusRMKRequest $request)
    {
        $rmk = $this->rmkRepository->byId($request->id);
        if (empty($rmk)) {
            throw new RMKNotFoundException("RMK not exists");
        }
        $this->rmkRepository->delete($request->id);
    }
}