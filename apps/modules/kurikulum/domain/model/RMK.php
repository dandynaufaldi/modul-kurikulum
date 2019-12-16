<?php

namespace Siakad\Kurikulum\Domain\Model;

use Siakad\Kurikulum\Domain\Model\UserRepository;

class RMK
{
    private $id;
    private $kode;
    private $nama;
    private $ketua;

    public function __construct(
        RMKId $id,
        string $kode,
        NamaBilingual $nama,
        User $ketua
    )
    {
        $this->id = $id;
        $this->kode = $kode;
        $this->nama = $nama;
        $this->ketua = $ketua;
    }

    public function id() : RMKId
    {
        return $this->id;
    }

    public function kode() : string
    {
        return $this->kode;
    }

    public function nama() : NamaBilingual
    {
        return $this->nama;
    }

    public function ketua() : User
    {
        return $this->ketua;
    }

}
