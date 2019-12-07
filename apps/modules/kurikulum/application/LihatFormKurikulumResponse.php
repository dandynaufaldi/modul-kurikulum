<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\Kurikulum;
use Siakad\Kurikulum\Domain\Model\ProgramStudi;

class LihatFormKurikulumResponse
{
    public $kurikulum;
    public $listProgramStudi;


    public function __construct(Kurikulum $kurikulum = null)
    {
        $this->kurikulum = $kurikulum ? KurikulumViewModel::fromKurikulum($kurikulum) : $kurikulum;
        $this->listProgramStudi = array();
    }

    public function addProgramStudi(ProgramStudi $programStudi)
    {
        $viewModel = ProgramStudiViewModel::fromProgramStudi($programStudi);
        $this->listProgramStudi[] = $viewModel;
    }
}