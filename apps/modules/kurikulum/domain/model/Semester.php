<?php

namespace Siakad\Kurikulum\Domain\Model;

use InvalidArgumentException;

class Semester
{
    public static $genap = 'genap';
    public static $ganjil = 'ganjil';

    private $semester;
    private $intValue;

    public function __construct(string $semester)
    {
        $semester = strtolower($semester);
        if (!Semester::validate($semester)) {
            throw new InvalidArgumentException('Invalid semester value');
        }
        $this->semester = $semester;
        $this->intValue = $this->semester === self::$genap ? 0 : 1;
    }

    public static function validate (string $value)
    {
        $value = strtolower($value);
        $allowedValue = [
            self::$ganjil,
            self::$genap
        ];
        return in_array($value, $allowedValue, true);
    }

    public function semester()
    {
        return $this->semester;
    }

    public function isEqual(Semester $other)
    {
        return $this->semester === $other->semester();
    }

    public function isGreater(Semester $other)
    {
        return $this->intValue > $other->intValue;
    }
}