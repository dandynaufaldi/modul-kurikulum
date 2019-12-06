<?php

namespace Siakad\Kurikulum\Application;

class CreateKurikulumRequest
{
    public $kodeProgramStudi;
    public $namaIndonesia;
    public $namaInggris;
    public $sksLulus;
    public $sksWajib;
    public $sksPilihan;
    public $semesterNormal;
    public $tahunMulai;
    public $tahunSelesai;
    public $semesterMulai;

    public function __construct(
        string $kodeProgramStudi,
        string $namaIndonesia,
        string $namaInggris,
        int $sksLulus,
        int $sksWajib,
        int $sksPilihan,
        int $semesterNormal,
        int $tahunMulai,
        int $tahunSelesai,
        string $semesterMulai
    )
    {
        $this->kodeProgramStudi = $kodeProgramStudi;
        $this->namaIndonesia = $namaIndonesia;
        $this->namaInggris = $namaInggris;
        $this->sksLulus = $sksLulus;
        $this->sksWajib = $sksWajib;
        $this->sksPilihan = $sksPilihan;
        $this->semesterNormal = $semesterNormal;
        $this->tahunMulai = $tahunMulai;
        $this->tahunSelesai = $tahunSelesai;
        $this->semesterMulai = $semesterMulai;
    }
}