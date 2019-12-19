<?php

namespace Siakad\Kurikulum\Domain\Model;

use InvalidArgumentException;

class Kurikulum
{
    private $id;
    private $prodi;
    private $aktif;
    private $nama;
    private $sksLulus;
    private $sksWajib;
    private $sksPilihan;
    private $semesterNormal;
    private $periode;
    private $semesterMulai;
    private $listMataKuliah;

    public function __construct(
        KurikulumId $id,
        ProgramStudi $prodi,
        NamaBilingual $nama,
        int $sksLulus,
        int $sksWajib,
        int $sksPilihan,
        int $semesterNormal,
        PeriodeTahun $periode,
        Semester $semesterMulai,
        $aktif = false,
        array $listMataKuliah = array()
    )
    {
        if (!self::validateAktifPeriode($aktif, $periode)) {
            throw new InvalidArgumentException('Waktu periode kurikulum telah terlewati');
        }
        $this->id = $id;
        $this->prodi = $prodi;
        $this->nama = $nama;
        $this->sksLulus = $sksLulus;
        $this->sksWajib = $sksWajib;
        $this->sksPilihan = $sksPilihan;
        $this->semesterNormal = $semesterNormal;
        $this->periode = $periode;
        $this->semesterMulai = $semesterMulai;
        $this->aktif = $aktif;
        $this->listMataKuliah = $listMataKuliah;
        $this->hitungSksWajib();
    }

    public static function validateAktifPeriode(bool $aktif, PeriodeTahun $periode) : bool
    {
        if ($aktif) {
            $tahunSekarang = Tahun::now();
            if ($tahunSekarang->isGreater($periode->selesai())) {
                return false;
            }
        }
        return true;
    }

    public static function builder()
    {
        return new KurikulumBuilder();
    }

    public function getId() : KurikulumId
    {
        return $this->id;
    }

    public function getProdi() : ProgramStudi
    {
        return $this->prodi;
    }

    public function getNama() : NamaBilingual
    {
        return $this->nama;
    }

    public function setNama(NamaBilingual $nama) : self
    {
        $this->nama = $nama;
        return $this;
    }

    public function getSksLulus() : int
    {
        return $this->sksLulus;
    }

    public function setSksLulus(int $sksLulus) : self
    {
        $this->sksLulus = $sksLulus;
        return $this;
    }

    public function getSksWajib() : int
    {
        return $this->sksWajib;
    }

    public function setSksWajib(int $sksWajib) : self
    {
        $this->sksWajib = $sksWajib;
        return $this;
    }

    public function getSksPilihan() : int
    {
        return $this->sksPilihan;
    }

    public function setSksPilihan(int $sksPilihan) : self
    {
        $this->sksPilihan = $sksPilihan;
        return $this;
    }

    public function getSemesterNormal() : int
    {
        return $this->semesterNormal;
    }

    public function setSemesterNormal(int $semesterNormal) : self
    {
        $this->semesterNormal = $semesterNormal;
        return $this;
    }

    public function getSemesterMulai() : Semester
    {
        return $this->semesterMulai;
    }

    public function setSemesterMulai(Semester $semesterMulai) : self
    {
        $this->semesterMulai = $semesterMulai;
        return $this;
    }

    public function getAktif() : bool
    {
        return $this->aktif;
    }

    public function aktif() : self
    {
        $aktif = true;
        if (!self::validateAktifPeriode($aktif, $this->getPeriode())) {
            throw new InvalidArgumentException('Waktu periode kurikulum telah terlewati');
        }
        $this->aktif = $aktif;
        return $this;
    }

    public function nonAktif() : self
    {
        $this->aktif = false;
        return $this;
    }

    public function getPeriode() : PeriodeTahun
    {
        return $this->periode;
    }

    public function setPeriode(PeriodeTahun $periode)
    {
        $this->periode = $periode;
        return $this;
    }

    public function getListMataKuliah() : array
    {
        return $this->listMataKuliah;
    }

    public function kelolaMataKuliah(MataKuliah $mataKuliah)
    {
        $found = false;
        foreach ($this->listMataKuliah as $existingMK) {
            if ($mataKuliah->getId()->isEqual($existingMK->getId())){
                $existingMK->setSifat($mataKuliah->getSifat());
                $existingMK->setSks($mataKuliah->getSks());
                $existingMK->setStatus(MataKuliah::$ubah);
                $found = true;
                break;
            }
        }
        if (!$found) {
            $mataKuliah->setStatus(MataKuliah::$baru);
            $this->listMataKuliah[] = $mataKuliah;
        }
        $this->hitungSksWajib();
    }

    public function hapusMataKuliah(MataKuliah $mataKuliah)
    {
        foreach ($this->listMataKuliah as $existingMK) {
            if ($mataKuliah->getId()->isEqual($existingMK->getId())) {
                $existingMK->setStatus(MataKuliah::$hapus);
                break;
            }
        }
        $this->hitungSksWajib();
    }

    private function hitungSksWajib()
    {
        $total = 0;
        foreach ($this->listMataKuliah as $mataKuliah) {
            if ($mataKuliah->getSifat() == SifatMataKuliah::$wajib) {
                $total += $mataKuliah->getSks();
            }
        }
        $this->sksWajib = $total;
    }
}