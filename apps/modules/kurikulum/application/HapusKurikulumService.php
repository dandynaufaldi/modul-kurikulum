<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\KurikulumRepository;

class HapusKurikulumService
{
    private $kurikulumRepository;

    public function __construct(KurikulumRepository $kurikulumRepository)
    {
        $this->kurikulumRepository = $kurikulumRepository;
    }

    public function execute(HapusKurikulumRequest $request)
    {
        $kurikulum = $this->kurikulumRepository->byId($request->id);
        if (empty($kurikulum)) {
            throw new KurikulumNotFoundException("Kurikulum {$request->id->id()} not exists");
        }
        $this->kurikulumRepository->delete($request->id);
    }
}