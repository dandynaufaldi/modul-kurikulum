<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\ProgramStudiRepository;

class ViewFormCreateRMKService
{
    private $programStudiRepository;

    public function __construct(ProgramStudiRepository $programStudiRepository)
    {
        $this->programStudiRepository = $programStudiRepository;
    }

    public function execute()
    {
        $listProgramStudi = $this->programStudiRepository->all();
        $response = new ViewFormCreateRMKResponse();
        foreach ($$listProgramStudi as $programStudi) {
            $response->addProgramStudi($programStudi);
        }
        return $response;
    }
}