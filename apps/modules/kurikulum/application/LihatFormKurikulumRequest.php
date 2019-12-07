<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\KurikulumId;

class LihatFormKurikulumRequest
{
    public $kurikulumId;

    public function __construct(string $kurikulumId = null)
    {
        $this->kurikulumId = $kurikulumId ? new KurikulumId($kurikulumId) : $kurikulumId;
    }
}