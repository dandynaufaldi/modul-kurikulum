<?php


namespace Siakad\Kurikulum\Application;


use Siakad\Kurikulum\Domain\Model\MataKuliah;

class LihatDaftarMataKuliahResponse
{
    public $listMataKuliah;

    public function __construct()
    {
        $this->listMataKuliah = array();
    }

    public function addMataKuliah(MataKuliah $mataKuliah) : void
    {
        $viewModel = MataKuliahViewModel::fromMataKuliah($mataKuliah);
        $this->listMataKuliah[] = $viewModel;
    }
}