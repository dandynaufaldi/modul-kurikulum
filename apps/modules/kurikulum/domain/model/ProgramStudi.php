<?php

namespace Siakad\Kurikulum\Domain\Model;

use InvalidArgumentException;

class ProgramStudi
{
    private $kaprodi;
    private $kode;
    private $nama;

    public function __construct(
        User $kaprodi,
        string $kode,
        NamaBilingual $nama
    )
    {
        if (!$kaprodi->isAllowed(UserRole::make(UserRole::$LEVEL_KAPRODI))) {
            throw new InvalidArgumentException('Kaprodi user has invalid level');
        }
        $this->kaprodi = $kaprodi;
        $this->kode = $kode;
        $this->nama = $nama;
    }

    public function kaprodi()
    {
        return $this->kaprodi;
    }

    public function kode()
    {
        return $this->kode;
    }

    public function nama()
    {
        return $this->nama;
    }
}