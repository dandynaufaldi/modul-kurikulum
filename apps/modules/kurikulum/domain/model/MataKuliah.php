<?php

namespace Siakad\Kurikulum\Domain\Model;

class MataKuliah
{
    private $id;
    private $rmk;
    private $kode;
    private $nama;
    private $deskripsi;
    private $sks;
    private $sifat;

    public function __construct(
        MataKuliahId $id,
        RMK $rmk,
        string $kode,
        NamaBilingual $nama,
        string $deskripsi,
        int $sks,
        SifatMataKuliah $sifat
    )
    {
        $this->id = $id;
        $this->rmk = $rmk;
        $this->kode = $kode;
        $this->nama = $nama;
        $this->deskripsi = $deskripsi;
        $this->sks = $sks;
        $this->sifat = $sifat;
    }

    /**
     * @return MataKuliahId
     */
    public function getId(): MataKuliahId
    {
        return $this->id;
    }

    /**
     * @return RMK
     */
    public function getRmk(): RMK
    {
        return $this->rmk;
    }

    /**
     * @return string
     */
    public function getKode(): string
    {
        return $this->kode;
    }

    /**
     * @return NamaBilingual
     */
    public function getNama(): NamaBilingual
    {
        return $this->nama;
    }

    /**
     * @return string
     */
    public function getDeskripsi(): string
    {
        return $this->deskripsi;
    }

    /**
     * @return int
     */
    public function getSks(): int
    {
        return $this->sks;
    }

    /**
     * @return SifatMataKuliah
     */
    public function getSifat(): SifatMataKuliah
    {
        return $this->sifat;
    }

}