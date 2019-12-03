<?php

namespace Siakad\Kurikulum\Domain\Model;

interface RMKRepository
{
    public function byKode(string $kode) : ?RMK;
    public function all(): ?array;
}