<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\KurikulumId;

class KelolaKurikulumRequest
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
    public $aktif;
    public $id;

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
        string $semesterMulai,
        bool $aktif = false,
        string $id = null
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
        $this->aktif = $aktif;
        $this->id = new KurikulumId($id);
    }
}