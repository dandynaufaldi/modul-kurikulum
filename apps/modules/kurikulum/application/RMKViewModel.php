<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\RMK;

class RMKViewModel
{
    public $id;
    public $kode;
    public $namaIndonesia;
    public $ketua;

    public function __construct(
        string $id,
        string $kode,
        string $namaIndonesia,
        UserViewModel $ketua
    )
    {
        $this->id = $id;
        $this->kode = $kode;
        $this->namaIndonesia = $namaIndonesia;
        $this->ketua = $ketua;
    }

    public static function fromRMK(RMK $rmk) : RMKViewModel
    {
        return new RMKViewModel(
            $rmk->id()->id(),
            $rmk->kode(),
            $rmk->nama()->indonesia(),
            UserViewModel::fromUser($rmk->ketua())
        );
    }

}
