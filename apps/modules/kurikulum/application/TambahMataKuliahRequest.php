<?php


namespace Siakad\Kurikulum\Application;


use Siakad\Kurikulum\Domain\Model\KurikulumId;
use Siakad\Kurikulum\Domain\Model\MataKuliah;

class TambahMataKuliahRequest
{
    public $kurikulumId;
    public $mataKuliah;

    /**
     * TambahMataKuliahRequest constructor.
     * @param $kurikulumId
     * @param $mataKuliah
     */
    public function __construct(
        KurikulumId $kurikulumId,
        MataKuliah $mataKuliah
    )
    {
        $this->kurikulumId = $kurikulumId;
        $this->mataKuliah = $mataKuliah;
    }


}