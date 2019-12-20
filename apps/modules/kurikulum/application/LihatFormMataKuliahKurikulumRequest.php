<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\KurikulumId;
use Siakad\Kurikulum\Domain\Model\MataKuliahId;

class LihatFormMataKuliahKurikulumRequest
{
    public $kurikulumId;
    public $mataKuliahId;

    public function __construct(string $kurikulumId, string $mataKuliahId = NULL)
    {
        $this->kurikulumId = new KurikulumId($kurikulumId);
        $this->mataKuliahId = $mataKuliahId ? new MataKuliahId($mataKuliahId) : $mataKuliahId;
    }
}