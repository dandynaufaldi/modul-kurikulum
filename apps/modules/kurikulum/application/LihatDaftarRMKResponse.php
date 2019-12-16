<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\RMK;

class LihatDaftarRMKResponse
{
    public $listRMK;

    public function __construct()
    {
        $this->listRMK = array();
    }

    public function addRMK(RMK $rmk)
    {
        $viewModel = RMKViewModel::fromRMK($rmk);
        $this->listRMK[] = $viewModel;
    }
}
