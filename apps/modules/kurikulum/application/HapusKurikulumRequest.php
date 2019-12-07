<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\KurikulumId;

class HapusKurikulumRequest
{
    public $id;

    public function __construct(string $id)
    {
        $this->id = new KurikulumId($id);
    }
}