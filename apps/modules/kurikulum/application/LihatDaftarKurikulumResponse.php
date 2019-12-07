<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\Kurikulum;

class LihatDaftarKurikulumResponse
{
    public $listKurikulum;

    public function __construct()
    {
        $this->listKurikulum = array();
    }

    public function addKurikulum(Kurikulum $kurikulum)
    {
        $viewModel = KurikulumViewModel::fromKurikulum($kurikulum);
        $this->listKurikulum[] = $viewModel;
    }
}