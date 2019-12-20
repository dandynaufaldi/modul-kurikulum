<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\KurikulumId;
use Siakad\Kurikulum\Domain\Model\MataKuliah;
use Siakad\Kurikulum\Domain\Model\RMK;

class LihatFormMataKuliahKurikulumResponse
{
    public $kurikulumId;
    public $mataKuliah;
    public $listRmk;

    public function __construct(KurikulumId $kurikulumId, MataKuliah $mataKuliah = NULL)
    {
        $this->kurikulumId = $kurikulumId->id();
        $this->mataKuliah = $mataKuliah ? MataKuliahViewModel::fromMataKuliah($mataKuliah) : $mataKuliah;
        $this->listRMK = array();
    }

    public function addRMK(RMK $rmk)
    {
        $this->listRmk[] = RMKViewModel::fromRMK($rmk);
    }
}