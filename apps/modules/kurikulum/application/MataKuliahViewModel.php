<?php


namespace Siakad\Kurikulum\Application;


use Siakad\Kurikulum\Domain\Model\MataKuliah;

class MataKuliahViewModel
{
    public $id;
    public $nama;
    public $kode;
    public $namaRmk;
    public $kodeRmk;
    public $deskripsi;

    /**
     * MataKuliahViewModel constructor.
     *
     * @param string $id
     * @param string $nama
     * @param string $kode
     * @param string $namaRmk
     * @param string $kodeRmk
     * @param string $deskripsi
     */
    public function __construct(
        string $id,
        string $nama,
        string $kode,
        string $namaRmk,
        string $kodeRmk,
        string $deskripsi
    )
    {
        $this->id = $id;
        $this->nama = $nama;
        $this->kode = $kode;
        $this->namaRmk = $namaRmk;
        $this->kodeRmk = $kodeRmk;
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
            $mataKuliah->getKode(),
            $mataKuliah->getRmk()->name(),
            $mataKuliah->getRmk()->kode(),
            $mataKuliah->getDeskripsi()
        );
    }

}