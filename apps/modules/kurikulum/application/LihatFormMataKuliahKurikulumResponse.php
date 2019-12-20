<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\KurikulumId;
use Siakad\Kurikulum\Domain\Model\MataKuliah;

class LihatFormMataKuliahKurikulumResponse
{
    public $kurikulumId;
    public $mataKuliah;

    public function __construct(KurikulumId $kurikulumId, MataKuliah $mataKuliah = NULL)
    {
        $this->kurikulumId = $kurikulumId->id();
        $this->mataKuliah = $mataKuliah ? MataKuliahViewModel::fromMataKuliah($mataKuliah) : $mataKuliah;
    }
}