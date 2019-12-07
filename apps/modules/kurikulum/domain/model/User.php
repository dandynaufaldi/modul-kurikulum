<?php

namespace Siakad\Kurikulum\Domain\Model;

class User
{
    private $id;
    private $identifier;
    private $name;
    private $role;

    public function __construct(
        int $id,
        string $identifier,
        string $name,
        UserRole $role
    )
    {
        $this->id = $id;
        $this->identifier = $identifier;
        $this->name = $name;
        $this->role = $role;
    }

    public function isAllowed(UserRole $minLevel)
    {
        return $this->role->isAllowed($minLevel);
    }

    public function id() : int
    {
        return $this->id;
    }

    public function identifier() : string
    {
        return $this->identifier;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function role() : UserRole
    {
        return $this->role;
    }
}