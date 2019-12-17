<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\RMK;
use Siakad\Kurikulum\Domain\Model\User;

class LihatFormRMKResponse
{
    public $rmk;
    public $listUser;

    public function __construct(RMK $rmk = null)
    {
        $this->listUser = array();
        $this->rmk = $rmk ? RMKViewModel::fromRMK($rmk) : null;
    }

    public function addUser(User $user)
    {
        $viewModel = UserViewModel::fromUser($user);
        $this->listUser[] = $viewModel;
    }
}