<?php


namespace Siakad\Kurikulum\Application;


use Siakad\Kurikulum\Domain\Model\MataKuliahId;

class HapusMataKuliahRequest
{
    public $id;

    /**
     * HapusMataKuliahRequest constructor.
     * @param $id
     */
    public function __construct(string $id)
    {
        $this->id = new MataKuliahId($id);
    }


}