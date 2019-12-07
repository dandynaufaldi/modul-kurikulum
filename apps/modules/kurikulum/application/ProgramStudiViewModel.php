<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\ProgramStudi;

class ProgramStudiViewModel
{
    public $nama;
    public $kode;
    public $kaprodi;

    public function __construct(
        string $nama,
        string $kode,
        UserViewModel $kaprodi
    )
    {
        $this->nama = $nama;
        $this->kode = $kode;
        $this->kaprodi = $kaprodi;
    }

    public static function fromProgramStudi(ProgramStudi $programStudi) : ProgramStudiViewModel
    {
        return new ProgramStudiViewModel(
            $programStudi->nama()->indonesia(),
            $programStudi->kode(),
            UserViewModel::fromUser($programStudi->kaprodi())
        );
    }
}