<?php

use Siakad\Kurikulum\Domain\Model\UserRole;
use PHPUnit\Framework\TestCase;
use Siakad\Kurikulum\Domain\Model\UnrecognizedUserRoleLevelException;

class UserRoleTest extends TestCase
{

    public function testCanBeInstantiated() : void
    {
        $userRole = new UserRole(UserRole::$LEVEL_MAHASISWA);

        $this->assertInstanceOf(UserRole::class, $userRole);
    }

    public function testCannotBeInstantiatedFromInvalidLevel() : void
    {
        $this->expectException(UnrecognizedUserRoleLevelException::class);

        $allowedLevel = [
            UserRole::$LEVEL_MAHASISWA,
            UserRole::$LEVEL_DOSEN,
            UserRole::$LEVEL_KAPRODI,
        ];

        do {
            $level = rand();
        } while (in_array($level, $allowedLevel));

        new UserRole($level);
    }

    public function testAllowSameLevel() : void
    {
        $firstUserRole = new UserRole(UserRole::$LEVEL_MAHASISWA);
        $secondUserRole = new UserRole(UserRole::$LEVEL_MAHASISWA);

        $this->assertTrue($firstUserRole->isAllowed($secondUserRole));
    }

    public function testAllowHigherLevel() : void
    {
        $firstUserRole = new UserRole(UserRole::$LEVEL_KAPRODI);
        $secondUserRole = new UserRole(UserRole::$LEVEL_MAHASISWA);

        $this->assertTrue($firstUserRole->isAllowed($secondUserRole));
    }

    public function testDisallowLowerLevel() : void
    {
        $firstUserRole = new UserRole(UserRole::$LEVEL_MAHASISWA);
        $secondUserRole = new UserRole(UserRole::$LEVEL_KAPRODI);

        $this->assertFalse($firstUserRole->isAllowed($secondUserRole));
    }
}
