<?php

use PHPUnit\Framework\TestCase;
use Siakad\Kurikulum\Domain\Model\User;
use Siakad\Kurikulum\Domain\Model\UserRole;

class UserTest extends TestCase
{
    public function testCanBeInstantiated() : void
    {
        $user = new User(1, '12345678901234', 'John Doe', new UserRole(1));

        $this->assertInstanceOf(User::class, $user);
    }

}
