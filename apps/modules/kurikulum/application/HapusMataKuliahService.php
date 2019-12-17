<?php


namespace Siakad\Kurikulum\Application;


use Siakad\Kurikulum\Domain\Model\MataKuliahRepository;

class HapusMataKuliahService
{
    private $mataKuliahRepository;

    /**
     * HapusMataKuliahService constructor.
     * @param $mataKuliahRepository
     */
    public function __construct(MataKuliahRepository $mataKuliahRepository)
    {
        $this->mataKuliahRepository = $mataKuliahRepository;
    }

    public function execute(HapusMataKuliahRequest $request) : void
    {
        $mataKuliah = $this->mataKuliahRepository->byId($request->id);
        if(empty($mataKuliah)) {
            throw new MataKuliahNotFoundException("Matakuliah {$request->id->id()} does not exist");
        } else {
            $this->mataKuliahRepository->delete($request->id);
        }
    }
}