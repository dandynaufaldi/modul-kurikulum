<?php


namespace Siakad\Kurikulum\Application;


use Siakad\Kurikulum\Domain\Model\MataKuliah;

class MataKuliahViewModel
{
    public $id;
    public $namaIndonesia;
    public $namaInggris;
    public $kode;
    public $rmk;
    public $deskripsi;

    /**
     * MataKuliahViewModel constructor.
     * @param string $id
     * @param string $namaIndonesia
     * @param string $namaInggris
     * @param string $kode
     * @param RMKViewModel $rmk
     * @param string $deskripsi
     */
    public function __construct(
        string $id,
        string $namaIndonesia,
        string $namaInggris,
        string $kode,
        RMKViewModel $rmk,
        string $deskripsi
    )
    {
        $this->id = $id;
        $this->namaIndonesia = $namaIndonesia;
        $this->namaInggris = $namaInggris;
        $this->kode = $kode;
        $this->rmk = $rmk;
        $this->deskripsi = $deskripsi;
    }



    /**
     * Generate MataKuliahviewModel from MataKuliah
     *
     * @param MataKuliah $mataKuliah
     * @return MataKuliahViewModel
     */
    public static function fromMataKuliah(MataKuliah $mataKuliah) : MataKuliahViewModel
    {
        return new MataKuliahViewModel(
            $mataKuliah->getId()->id(),
            $mataKuliah->getNama()->indonesia(),
            $mataKuliah->getNama()->inggris(),
            $mataKuliah->getKode(),
            RMKViewModel::fromRMK($mataKuliah->getRmk()),
            $mataKuliah->getDeskripsi()
        );
    }

}