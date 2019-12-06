<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\ProgramStudi;

class ViewFormCreateKurikulumResponse
{
    public $listProgramStudi;

    public function __construct()
    {
        $this->listProgramStudi = array();
    }

    public function addProgramStudi(ProgramStudi $programStudi)
    {
        $programStudiKV = [
            'kode' => $programStudi->kode(),
            'nama' => $programStudi->nama()->indonesia()
        ];
        $this->listProgramStudi[] = $programStudiKV;
    }
}