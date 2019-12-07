<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\User;

class UserViewModel
{
    public $identifier;
    public $nama;
    public $role;

    public function __construct(
        string $identifier,
        string $nama,
        int $role
    )
    {
        $this->identifier = $identifier;
        $this->nama = $nama;
        $this->role = $role;
    }

    public static function fromUser(User $user) : UserViewModel
    {
        return new UserViewModel(
            $user->identifier(),
            $user->name(),
            $user->role()->level()
        );
    }
}