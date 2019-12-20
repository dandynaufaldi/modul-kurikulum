<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\KurikulumId;
use Siakad\Kurikulum\Domain\Model\MataKuliahId;

class KelolaMataKuliahKurikulumRequest
{
    public $kurikulumId;
    public $mataKuliahId;
    public $kodeRMK;
    public $kodeMataKuliah;
    public $namaIndonesia;
    public $namaInggris;
    public $deskripsi;
    public $sks;
    public $sifat;
    public $semester;

    /**
     * KelolaMataKuliahKurikulumRequest constructor.
     * @param $kurikulumId
     * @param $mataKuliahId
     * @param $kodeRMK
     * @param $kodeMataKuliah
     * @param $namaIndonesia
     * @param $namaInggris
     * @param $deskripsi
     * @param $sks
     * @param $sifat
     * @param $status
     * @param $semester
     */
    public function __construct(
        string $kurikulumId,
        string $mataKuliahId,
        string $kodeRMK,
        string $kodeMataKuliah,
        string $namaIndonesia,
        string $namaInggris,
        string $deskripsi,
        int $sks,
        string $sifat,
        int $semester
    )
    {
        $this->kurikulumId = new KurikulumId($kurikulumId);
        $this->mataKuliahId = new MataKuliahId($mataKuliahId);
        $this->kodeRMK = $kodeRMK;
        $this->kodeMataKuliah = $kodeMataKuliah;
        $this->namaIndonesia = $namaIndonesia;
        $this->namaInggris = $namaInggris;
        $this->deskripsi = $deskripsi;
        $this->sks = $sks;
        $this->sifat = $sifat;
        $this->semester = $semester;
    }


}