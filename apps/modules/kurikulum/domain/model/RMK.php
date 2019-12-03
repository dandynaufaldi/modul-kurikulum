<?php

namespace Siakad\Kurikulum\Domain\Model;

use Siakad\Kurikulum\Domain\Model\UserRepository;

class RMK
{
    private $kode;
    private $name;
    private $ketua;

    public function __construct(
        string $kode,
        string $name,
        User $ketua
    )
    {
        $this->kode = $kode;
        $this->name = $name;
        $this->ketua = $ketua;
    }

    public function kode()
    {
        return $this->kode;
    }

    public function name()
    {
        return $this->name;
    }

    public function ketua()
    {
        return $this->ketua;
    }
    
    public static function makeRMK($kode, $name, $idKetua)
    {   
        $newRMK = new RMK($kode, $name, UserRepository::byId($idKetua));
        
        return $newRMK;
    }

}