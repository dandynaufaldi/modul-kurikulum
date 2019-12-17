<?php


namespace Siakad\Kurikulum\Application;


use Siakad\Kurikulum\Domain\Model\MataKuliahRepository;
use Siakad\Kurikulum\Domain\Model\RMKRepository;

class LihatFormMataKuliahService
{
    private $rmkRepository;
    private $mataKuliahRepository;

    /**
     * LihatFormMataKuliahService constructor.
     * @param $rmkRepository
     * @param $mataKuliahRepository
     */
    public function __construct(
        RMKRepository $rmkRepository,
        MataKuliahRepository $mataKuliahRepository
    )
    {
        $this->rmkRepository = $rmkRepository;
        $this->mataKuliahRepository = $mataKuliahRepository;
    }

    public function execute(LihatFormMataKuliahRequest $request) : LihatFormMataKuliahResponse
    {
        $listRmk = $this->rmkRepository->all();
        $mataKuliahId = $request->mataKuliahId;

        if(empty($mataKuliahId)) {
            $response = new LihatFormMataKuliahResponse();
        } else {
            $mataKuliah = $this->mataKuliahRepository->byId($mataKuliahId);
            if(empty($mataKuliah)) {
                throw new MataKuliahNotFoundException("Mata Kuliah {$request->mataKuliahId->id()} does not exist");
            }
            $response = new LihatFormMataKuliahResponse($mataKuliah);
        }

        foreach ($listRmk as $rmk) {
            $response->addRMK($rmk);
        }

        return $response;
    }


}