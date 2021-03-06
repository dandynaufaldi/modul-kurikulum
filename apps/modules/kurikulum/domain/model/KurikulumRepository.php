<?php

namespace Siakad\Kurikulum\Domain\Model;

interface KurikulumRepository
{
    public function byId(KurikulumId $kurikulumId) : ?Kurikulum;
    public function all() : array;
    public function save(Kurikulum $kurikulum) : void;
    public function delete(KurikulumId $kurikulumId) : void;
    public function fetchMataKuliahById(KurikulumId $kurikulumId, MataKuliahId $mataKuliahId) : ?MataKuliah;
}