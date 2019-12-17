<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\RMKId;

class HapusRMKRequest
{
    public $id;

    public function __construct(string $id)
    {
        $this->id = new RMKId($id);
    }
}