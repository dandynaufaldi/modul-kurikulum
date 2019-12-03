<?php

namespace Siakad\Kurikulum\Domain\Model;

use InvalidArgumentException;

class UserRole
{
    public static $LEVEL_KAPRODI = 5;
    public static $LEVEL_DOSEN = 3;
    public static $LEVEL_MAHASISWA = 1;

    private $level;

    public function __construct(int $level)
    {
        if (!UserRole::validate($level)) {
            throw new InvalidArgumentException("Invalid user role level");
        }
        $this->level = $level;
    }

    private static function validate(int $level)
    {
        $allowedLevel = [
            UserRole::$LEVEL_KAPRODI,
            UserRole::$LEVEL_DOSEN,
            UserRole::$LEVEL_MAHASISWA
        ];
        return in_array($level, $allowedLevel, true);
    }

    public function isAllowed(UserRole $minRole) : bool
    {
        return $this->level >= $minRole->level();
    }

    public function level()
    {
        return $this->level;
    }

    public static function make(int $level) : UserRole
    {
        return new UserRole($level);
    }
}