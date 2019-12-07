<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\KurikulumId;
use Siakad\Kurikulum\Domain\Model\KurikulumRepository;

class ViewFormEditKurikulumService
{
    private $kurikulumRepository;

    public function __construct(
        KurikulumRepository $kurikulumRepository
    )
    {
        $this->kurikulumRepository = $kurikulumRepository;
    }

    public function execute(ViewFormEditKurikulumRequest $request)
    {
        $kurikulum = $this->kurikulumRepository->byId($request->kurikulumId);
        if (empty($kurikulum)) {
            throw new KurikulumNotFoundException("Kurikulum {$request->kurikulumId->id()} not exists");
        }
        return new ViewFormEditKurikulumResponse($kurikulum);
    }
}