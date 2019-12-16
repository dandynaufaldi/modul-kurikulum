<?php

namespace Siakad\Kurikulum\Application;

class LihatDaftarRMKResponse
{
    public $listRMK;

    public function __construct()
    {
        $this->listRMK = array();
    }

    public function addRMKResponse(
        string $id,
        string $kode,
        string $namaIndonesia,
        string $namaKetua
    )
    {
        $RMK = array(
            'id' => $id,
            'kode' => $kode,
            'namaIndonesia' => $namaIndonesia,
            'namaKetua' => $namaKetua,
        );

        array_push($this->listRMK, $RMK);
    }
}
