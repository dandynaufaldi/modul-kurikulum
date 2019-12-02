<?php

namespace Siakad\Kurikulum\Domain\Model;

class User
{
    private $id;
    private $identifier;
    private $name;
    private $userRole;

    public static $LEVEL_KAPRODI = 5;
    public static $LEVEL_DOSEN = 3;
    public static $LEVEL_MAHASISWA = 1;

    public function __construct(
        int $id,
        string $identifier,
        string $name,
        UserRole $userRole
    )
    {
        $this->id = $id;
        $this->identifier = $identifier;
        $this->name = $name;
        $this->userRole = $userRole;
    }

    public function isAllowed(UserRole $minLevel)
    {
        return $this->userRole->isAllowed($minLevel);
    }

    public function id()
    {
        return $this->id;
    }

    public function identifier()
    {
        return $this->identifier;
    }

    public function name()
    {
        return $this->name;
    }

    public function level()
    {
        return $this->level;
    }
}