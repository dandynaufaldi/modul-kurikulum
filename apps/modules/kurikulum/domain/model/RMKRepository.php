<?php

namespace Siakad\Kurikulum\Domain\Model;

interface RMKRepository
{
    public function byId(RMKId $id);
    public function byKode(string $kode);
    public function all(): ?array;
    public function save(RMK $rmk);
    public function delete(RMKId $rmkId);
}