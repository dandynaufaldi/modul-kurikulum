<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\KurikulumRepository;
use Siakad\Kurikulum\Domain\Model\ProgramStudiRepository;

class LihatFormKurikulumService
{
    private $kurikulumRepository;
    private $programStudiRepository;

    public function __construct(
        KurikulumRepository $kurikulumRepository,
        ProgramStudiRepository $programStudiRepository
    )
    {
        $this->kurikulumRepository = $kurikulumRepository;
        $this->programStudiRepository = $programStudiRepository;
    }

    public function execute(LihatFormKurikulumRequest $request)
    {
        $listProgramStudi = $this->programStudiRepository->all();
        $kurikulumId = $request->kurikulumId;

        if (empty($kurikulumId)) {
            $response = new LihatFormKurikulumResponse();
        } else {
            $kurikulum = $this->kurikulumRepository->byId($request->kurikulumId);
            if (empty($kurikulum)) {
                throw new KurikulumNotFoundException("Kurikulum {$request->kurikulumId->id()} not exists");
            }
            $response = new LihatFormKurikulumResponse($kurikulum);
        }
        
        foreach ($listProgramStudi as $programStudi) {
            $response->addProgramStudi($programStudi);
        }

        return $response;
    }
}