<?php

namespace Siakad\Kurikulum\Domain\Model;

interface RMKRepository
{
    public function byid(string $id);
    public function byKode(string $kode);
    public function all(): ?array;
    public function save(RMK $rmk);
    public function delete(RMKId $rmkId);
}