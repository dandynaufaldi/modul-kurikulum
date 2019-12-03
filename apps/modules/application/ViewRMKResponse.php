<?php

namespace Siakad\Kurikulum\Application;

class ViewRMKResponse
{
    public $listRMK;

    public function __construct()
    {
        $this->listRMK = array();
    }

    public function addRMKResponse(
        string $kode,
        string $name,
        string $namaKetua
    )
    {
        $RMK = array(
            'kode' => $kode,
            'name' => $name,
            'namaKetua' => $namaKetua,
        );

        array_push($this->listRMK, $RMK);
    }
}
