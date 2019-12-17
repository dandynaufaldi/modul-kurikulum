<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\RMK;

class RMKViewModel
{
    public $id;
    public $kode;
    public $namaIndonesia;
    public $namaInggris;
    public $ketua;

    public function __construct(
        string $id,
        string $kode,
        string $namaIndonesia,
        string $namaInggris,
        UserViewModel $ketua
    )
    {
        $this->id = $id;
        $this->kode = $kode;
        $this->namaIndonesia = $namaIndonesia;
        $this->namaInggris = $namaInggris;
        $this->ketua = $ketua;
    }

    public static function fromRMK(RMK $rmk) : RMKViewModel
    {
        return new RMKViewModel(
            $rmk->id()->id(),
            $rmk->kode(),
            $rmk->nama()->indonesia(),
            $rmk->nama()->inggris(),
            UserViewModel::fromUser($rmk->ketua())
        );
    }

}
