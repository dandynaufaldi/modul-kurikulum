<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\KurikulumId;

class ViewFormEditKurikulumRequest
{
    public $kurikulumId;

    public function __construct(string $kurikulumId)
    {
        $this->kurikulumId = new KurikulumId($kurikulumId);
    }
}