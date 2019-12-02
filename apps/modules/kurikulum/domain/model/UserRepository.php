<?php

namespace Siakad\Kurikulum\Domain\Model;

interface UserRepository
{
    public function byId(int $id) : ?User;
    public function byIdentifierAndPassword(string $identifier, string $password) : ?User;
}