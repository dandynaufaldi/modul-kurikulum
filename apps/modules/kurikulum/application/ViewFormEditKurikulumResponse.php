<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\Kurikulum;
use stdClass;

class ViewFormEditKurikulumResponse
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

    public function __construct(Kurikulum $kurikulum)
    {
        $this->id = $kurikulum->getId()->id();
        
        $programStudiObj = $kurikulum->getProdi();
        $programStudi = new stdClass();
        $programStudi->nama = $programStudiObj->nama()->indonesia();
        $programStudi->kode = $programStudiObj->kode();
        $this->programStudi = $programStudi;
        
        $this->namaIndonesia = $kurikulum->getNama()->indonesia();
        $this->namaInggris = $kurikulum->getNama()->inggris();
        $this->semesterMulai = $kurikulum->getSemesterMulai()->semester();
        $this->semesterNormal = $kurikulum->getSemesterNormal();
        $this->tahunMulai = $kurikulum->getPeriode()->mulai()->tahun();
        $this->tahunSelesai = $kurikulum->getPeriode()->selesai()->tahun();
        $this->sksLulus = $kurikulum->getSksLulus();
        $this->sksWajib = $kurikulum->getSksWajib();
        $this->sksPilihan = $kurikulum->getSksPilihan();
    }
}