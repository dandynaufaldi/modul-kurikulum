<?php

namespace Siakad\Kurikulum\Domain\Model;

interface MataKuliahRepository
{
    public function byId(MataKuliahId $mataKuliahId) : ?MataKuliah;
    public function all() : array;
    public function save(MataKuliah $mataKuliah) : void;
    public function delete(MataKuliahId $mataKuliahId) : void;
}