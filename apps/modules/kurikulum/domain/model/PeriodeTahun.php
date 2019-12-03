<?php

namespace Siakad\Kurikulum\Domain\Model;

use InvalidArgumentException;

class PeriodeTahun
{
    private $mulai;
    private $selesai;

    public function __construct(
        Tahun $mulai,
        Tahun $selesai
    )
    {
        if (!self::validate($mulai, $selesai)) {
            throw new InvalidArgumentException('Tahun selesai harus lebih dari tahun mulai');
        }
        $this->mulai = $mulai;
        $this->selesai = $selesai;
    }

    public static function validate(
        Tahun $mulai,
        Tahun $selesai
    ) : bool
    {
        return $selesai->isGreater($mulai);
    }

    public function mulai()
    {
        return $this->mulai;
    }

    public function selesai()
    {
        return $this->selesai;
    }

    public function intersect(PeriodeTahun $other) : bool
    {
        return $this->selesai->isGreater($other->selesai());
    }
}