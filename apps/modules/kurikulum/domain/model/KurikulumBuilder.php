<?php

namespace Siakad\Kurikulum\Domain\Model;

use InvalidArgumentException;
use TypeError;

class KurikulumBuilder
{
    private $id = NULL;
    private $prodi = NULL;
    private $aktif = NULL;
    private $nama = NULL;
    private $sksLulus = NULL;
    private $sksWajib = NULL;
    private $sksPilihan = NULL;
    private $semesterNormal = NULL;
    private $periode = NULL;
    private $semesterMulai = NULL;
    private $listMataKuliah = NULL;

    public function __construct()
    {
        $this->aktif = false;
        $this->id = new KurikulumId();
        $this->listMataKuliah = array();
    }

    public function id(KurikulumId $id)
    {
        $this->id = $id;
        return $this;
    }

    public function prodi(ProgramStudi $prodi)
    {
        $this->prodi = $prodi;
        return $this;
    }

    public function nama(NamaBilingual $nama)
    {
        $this->nama = $nama;
        return $this;
    }

    public function sksLulus(int $sksLulus) : self
    {
        $this->sksLulus = $sksLulus;
        return $this;
    }

    public function sksWajib(int $sksWajib) : self
    {
        $this->sksWajib = $sksWajib;
        return $this;
    }

    public function sksPilihan(int $sksPilihan) : self
    {
        $this->sksPilihan = $sksPilihan;
        return $this;
    }

    public function semesterNormal(int $semesterNormal) : self
    {
        $this->semesterNormal = $semesterNormal;
        return $this;
    }

    public function periode(PeriodeTahun $periode) : self
    {
        $this->periode = $periode;
        return $this;
    }

    public function semesterMulai(Semester $semesterMulai) : self
    {
        $this->semesterMulai = $semesterMulai;
        return $this;
    }

    public function aktif($aktif) : self
    {
        $this->aktif = boolval($aktif);
        return $this;
    }

    public function listMataKuliah(array $listMataKuliah) : self
    {
        $this->listMataKuliah = $listMataKuliah;
        return $this;
    }

    public function build() : Kurikulum
    {
       try {
           $kurikulum =  new Kurikulum(
                $this->id,
                $this->prodi,
                $this->nama,
                $this->sksLulus,
                $this->sksWajib,
                $this->sksPilihan,
                $this->semesterNormal,
                $this->periode,
                $this->semesterMulai,
                $this->aktif,
                $this->listMataKuliah
            );
            return $kurikulum;
       } catch (TypeError $e) {
           throw new MissingBuilderStepException('Missing step in building Kurikulum object');
       }
    }
}