<?php


namespace Siakad\Kurikulum\Application;


use Siakad\Kurikulum\Domain\Model\MataKuliah;
use Siakad\Kurikulum\Domain\Model\MataKuliahRepository;
use Siakad\Kurikulum\Domain\Model\NamaBilingual;
use Siakad\Kurikulum\Domain\Model\RMKRepository;

class KelolaMataKuliahService
{
    private $rmkRepository;
    private $mataKuliahRepository;

    /**
     * KelolaMataKuliahService constructor.
     * @param $rmkRepository
     * @param $mataKuliahRepository
     */
    public function __construct(
        RMKRepository $rmkRepository,
        MataKuliahRepository$mataKuliahRepository
    )
    {
        $this->rmkRepository = $rmkRepository;
        $this->mataKuliahRepository = $mataKuliahRepository;
    }

    public function execute(KelolaMataKuliahRequest $request)
    {
        $rmk = $this->rmkRepository->byKode($request->kodeRMK);
        if (empty($rmk)) {
            throw new RMKNotFoundException("RMK {$request->kodeRMK} does not exist");
        }

        $nama = new NamaBilingual(
            $request->namaIndonesia,
            $request->namaInggris
        );

        $mataKuliah = new MataKuliah(
            $request->id,
            $rmk,
            $request->kodeMataKuliah,
            $nama,
            $request->deskripsi
        );

        $this->mataKuliahRepository->save($mataKuliah);

    }
}