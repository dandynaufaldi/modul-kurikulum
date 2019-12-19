<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\Kurikulum;

class KurikulumViewModel
{
    public $id;
    public $programStudi;
    public $namaIndonesia;
    public $namaInggris;
    public $semesterMulai;
    public $semesterNormal;
    public $tahunMulai;
    public $tahunSelesai;
    public $sksLulus;
    public $sksWajib;
    public $sksPilihan;
    public $aktif;
    public $listMataKuliah;

    public function __construct(
        string $id,
        ProgramStudiViewModel $programStudi,
        string $namaIndonesia,
        string $namaInggris,
        string $semesterMulai,
        int $semesterNormal,
        int $tahunMulai,
        int $tahunSelesai,
        int $sksLulus,
        int $sksWajib,
        int $sksPilihan,
        bool $aktif,
        array $listMataKuliah
    )
    {
        $this->id = $id;
        $this->programStudi = $programStudi;
        $this->namaIndonesia = $namaIndonesia;
        $this->namaInggris = $namaInggris;
        $this->semesterMulai = $semesterMulai;
        $this->semesterNormal = $semesterNormal;
        $this->tahunMulai = $tahunMulai;
        $this->tahunSelesai = $tahunSelesai;
        $this->sksLulus = $sksLulus;
        $this->sksWajib = $sksWajib;
        $this->sksPilihan = $sksPilihan;
        $this->aktif = $aktif;

        $this->listMataKuliah = array();
        foreach ($listMataKuliah as $mataKuliah) {
            $this->listMataKuliah[] = MataKuliahViewModel::fromMataKuliah($mataKuliah);
        }
    }

    public static function fromKurikulum(Kurikulum $kurikulum) : KurikulumViewModel
    {
        return new KurikulumViewModel(
            $kurikulum->getId()->id(),
            ProgramStudiViewModel::fromProgramStudi($kurikulum->getProdi()),
            $kurikulum->getNama()->indonesia(),
            $kurikulum->getNama()->inggris(),
            $kurikulum->getSemesterMulai()->semester(),
            $kurikulum->getSemesterNormal(),
            $kurikulum->getPeriode()->mulai()->tahun(),
            $kurikulum->getPeriode()->selesai()->tahun(),
            $kurikulum->getSksLulus(),
            $kurikulum->getSksWajib(),
            $kurikulum->getSksPilihan(),
            $kurikulum->getAktif(),
            $kurikulum->getListMataKuliah()
        );
    }
}