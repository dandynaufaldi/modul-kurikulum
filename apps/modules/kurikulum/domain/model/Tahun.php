<?php

namespace Siakad\Kurikulum\Domain\Model;

use DateTime;

class Tahun
{
    private $tahun;

    public function __construct(int $tahun)
    {
        $this->tahun = $tahun;
    }

    public function tahun()
    {
        return $this->tahun;
    }

    public function isGreater(Tahun $other) : bool
    {
        return $this->tahun > $other->tahun();
    }

    public function isEqual(Tahun $other) : bool
    {
        return $this->tahun === $other->tahun();
    }

    public static function now() : Tahun
    {
        $now = new DateTime('now');
        $year = $now->format('Y');
        $tahun = new Tahun(intval($year));
        return $tahun;
    }
}