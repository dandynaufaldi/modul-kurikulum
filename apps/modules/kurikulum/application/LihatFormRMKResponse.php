<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\Kurikulum;
use Siakad\Kurikulum\Domain\Model\RMK;
use Siakad\Kurikulum\Domain\Model\User;

class LihatFormRMKResponse
{
    public $rmk;
    public $listKurikulum;
    public $listUser;

    public function __construct(RMK $rmk = null)
    {
        // $this->rmk = $rmk ? KurikulumViewModel::fromKurikulum($kurikulum) : $kurikulum;
        $this->listKurikulum = array();
        $this->listUser = array();
    }

    public function addKurikulum(Kurikulum $kurikulum)
    {
        $viewModel = KurikulumViewModel::fromKurikulum($kurikulum);
        $this->listKurikulum[] = $viewModel;
    }

    public function addUser(User $user)
    {
        $viewModel = UserViewModel::fromUser($user);
        $this->listUser[] = $viewModel;
    }
}