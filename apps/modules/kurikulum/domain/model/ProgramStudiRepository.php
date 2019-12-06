<?php

namespace Siakad\Kurikulum\Domain\Model;

interface ProgramStudiRepository
{
    public function all() : array;
    public function byKode(string $kode) : ?ProgramStudi;
}