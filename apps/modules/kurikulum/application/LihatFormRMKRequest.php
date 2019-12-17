<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\RMKId;

class LihatFormRMKRequest
{
    public $rmkId;

    public function __construct(string $rmkId = null)
    {
        $this->rmkId = $rmkId ? new RMKId($rmkId) : $rmkId;
    }
}