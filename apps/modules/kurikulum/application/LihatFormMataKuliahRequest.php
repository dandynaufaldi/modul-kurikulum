<?php


namespace Siakad\Kurikulum\Application;


use Siakad\Kurikulum\Domain\Model\MataKuliahId;

class LihatFormMataKuliahRequest
{
    public $mataKuliahId;

    /**
     * LihatFormMataKuliahRequest constructor.
     * @param $mataKuliahId
     */
    public function __construct(string $mataKuliahId = null)
    {
        $this->mataKuliahId = $mataKuliahId ? new MataKuliahId($mataKuliahId) : null;
    }


}