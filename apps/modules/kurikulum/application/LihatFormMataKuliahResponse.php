<?php


namespace Siakad\Kurikulum\Application;


use Siakad\Kurikulum\Domain\Model\MataKuliah;
use Siakad\Kurikulum\Domain\Model\RMK;

class LihatFormMataKuliahResponse
{
    public $mataKuliah;
    public $listRmk;

    /**
     * LihatFormMataKuliahResponse constructor.
     * @param $mataKuliah
     * @param $listRmk
     */
    public function __construct(MataKuliah $mataKuliah = null)
    {
        $this->mataKuliah = $mataKuliah ? MataKuliahViewModel::fromMataKuliah($mataKuliah) : null;
        $this->listRmk = array();
    }

    public function addRMK(RMK $rmk)
    {
        $this->listRmk[] = RMKViewModel::fromRMK($rmk);
    }

}