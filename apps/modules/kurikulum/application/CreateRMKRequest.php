<?php

namespace Siakad\Kurikulum\Application;

class CreateRMKRequest
{
    public $kode;
    public $name;
    public $idKetua;

    public function __construct(
        string $kode, 
        string $name, 
        string $idKetua
    )
    {
        $this->kode = $kode;
        $this->name = $name;
        $this->idKetua = $idKetua;
    }
    
}
