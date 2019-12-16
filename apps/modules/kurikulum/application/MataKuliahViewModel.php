<?php


namespace Siakad\Kurikulum\Application;


use Siakad\Kurikulum\Domain\Model\MataKuliah;

class MataKuliahViewModel
{
    public $nama;
    public $rmk;
    public $kode;
    public $deskripsi;

    public function __construct(
        string $nama,
        string $rmk,
        string $kode,
        string $deskripsi
    )
    {
        $this->nama = $nama;
        $this->rmk = $rmk;
        $this->kode = $kode;
        $this->deskripsi = $deskripsi;
    }

    public static function fromMataKuliah(MataKuliah $mataKuliah) : MataKuliahViewModel
    {
        return new MataKuliahViewModel(
            $mataKuliah->getNama()->indonesia(),
            $mataKuliah->getRmk()->kode(),
            $mataKuliah->getKode(),
            $mataKuliah->getDeskripsi()
        );
    }

}