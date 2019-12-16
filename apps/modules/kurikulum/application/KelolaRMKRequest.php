<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\RMKId;

class KelolaRMKRequest
{
    public $kode;
    public $namaIndonesia;
    public $namaInggris;
    public $ketuaIdentifier;
    public $id;

    public function __construct(
        string $kode, 
        string $namaIndonesia,
        string $namaInggris,
        string $ketuaIdentifier,
        string $id = NULL
    )
    {
        $this->kode = $kode;
        $this->namaIndonesia = $namaIndonesia;
        $this->namaInggris = $namaInggris;
        $this->ketuaIdentifier = $ketuaIdentifier;
        $this->id = $id ?? new RMKId($id);
    }
    
}
