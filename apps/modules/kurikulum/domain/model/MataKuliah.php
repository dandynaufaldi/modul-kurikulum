<?php

namespace Siakad\Kurikulum\Domain\Model;

class MataKuliah
{

    public static $tetap = 0;
    public static $baru = 1;
    public static $ubah = 2;
    public static $hapus = 3;

    private $id;
    private $rmk;
    private $kode;
    private $nama;
    private $deskripsi;
    private $sks;
    private $sifat;
    private $status;
    private $semester;

    public function __construct(
        MataKuliahId $id,
        RMK $rmk,
        string $kode,
        NamaBilingual $nama,
        string $deskripsi,
        int $sks,
        SifatMataKuliah $sifat,
        int $semester,
        int $status = 0
    )
    {
        $this->id = $id;
        $this->rmk = $rmk;
        $this->kode = $kode;
        $this->nama = $nama;
        $this->deskripsi = $deskripsi;
        $this->sks = $sks;
        $this->sifat = $sifat;
        $this->status = $status;
        $this->semester = $semester;
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


    /**
     * @return int
     */ 
    public function getStatus() : int
    {
        return $this->status;
    }

    /**
     * @return int
     */ 
    public function getSemester() : int
    {
        return $this->semester;
    }

    /**
     * Set the value of sks
     *
     * @return  self
     */ 
    public function setSks(int $sks)
    {
        $this->sks = $sks;

        return $this;
    }

    /**
     * Set the value of sifat
     *
     * @return  self
     */ 
    public function setSifat(SifatMataKuliah $sifat)
    {
        $this->sifat = $sifat;

        return $this;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus(int $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Set the value of semester
     *
     * @return  self
     */ 
    public function setSemester(int $semester)
    {
        $this->semester = $semester;

        return $this;
    }
}