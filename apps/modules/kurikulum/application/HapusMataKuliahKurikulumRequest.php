<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\KurikulumId;
use Siakad\Kurikulum\Domain\Model\MataKuliahId;

class HapusMataKuliahKurikulumRequest
{
    public $kurikulumId;
    public $mataKuliahId;

    /**
     * HapusMataKuliahKurikulumRequest constructor.
     * @param $kurikulumId
     * @param $mataKuliahId
     */
    public function __construct(string $kurikulumId, string $mataKuliahId)
    {
        $this->kurikulumId = new KurikulumId($kurikulumId);
        $this->mataKuliahId = new MataKuliahId($mataKuliahId);
    }


}