<?php


namespace Siakad\Kurikulum\Application;


use Siakad\Kurikulum\Domain\Model\MataKuliahId;

class KelolaMataKuliahRequest
{
    public $kodeRMK;
    public $kodeMataKuliah;
    public $namaIndonesia;
    public $namaInggris;
    public $deskripsi;
    public $id;

    /**
     * KelolaMataKuliahRequest constructor.
     * @param string $kodeRMK
     * @param string $kodeMataKuliah
     * @param string $namaIndonesia
     * @param string $namaInggris
     * @param string $deskripsi
     * @param string|null $id
     */
    public function __construct(
        string $kodeRMK,
        string $kodeMataKuliah,
        string $namaIndonesia,
        string $namaInggris,
        string $deskripsi,
        string $id = null
    )
    {
        $this->kodeRMK = $kodeRMK;
        $this->kodeMataKuliah = $kodeMataKuliah;
        $this->namaIndonesia = $namaIndonesia;
        $this->namaInggris = $namaInggris;
        $this->deskripsi = $deskripsi;
        $this->id  = new MataKuliahId($id);
    }


}