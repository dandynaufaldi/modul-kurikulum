<?php

namespace Siakad\Kurikulum\Domain\Model;

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

    public function makeRMK(
        string $kode,
        string $namaIndonesia,
        string $namaInggris,
        User $ketua,
        string $id
    ) : RMK
    {
        return new RMK(
            new RMKId($id),
            $kode,
            new NamaBilingual(
                $namaIndonesia,
                $namaInggris
            ),
            $ketua
        );
    }
}
