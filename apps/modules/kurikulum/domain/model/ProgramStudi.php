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

    public function kaprodi() : User
    {
        return $this->kaprodi;
    }

    public function kode() : string
    {
        return $this->kode;
    }

    public function nama() : NamaBilingual
    {
        return $this->nama;
    }
}