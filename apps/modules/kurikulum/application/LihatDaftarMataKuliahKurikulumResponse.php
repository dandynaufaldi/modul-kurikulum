<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\Kurikulum;

class LihatDaftarMataKuliahKurikulumResponse
{
    public $kurikulum;

    public function __construct(Kurikulum $kurikulum)
    {
        $viewModel = KurikulumViewModel::fromKurikulum($kurikulum);
        $this->kurikulum = $viewModel;
    }

}
