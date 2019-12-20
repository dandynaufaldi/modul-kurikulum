<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\KurikulumRepository;
use Siakad\Kurikulum\Domain\Model\MataKuliah;
use Siakad\Kurikulum\Domain\Model\MataKuliahId;
use Siakad\Kurikulum\Domain\Model\NamaBilingual;
use Siakad\Kurikulum\Domain\Model\RMKRepository;
use Siakad\Kurikulum\Domain\Model\SifatMataKuliah;

class KelolaMataKuliahKurikulumService
{
    private $kurikulumRepository;
    private $rmkRepository;

    /**
     * KelolaMataKuliahKurikulumService constructor.
     * @param $kurikulumRepository
     */
    public function __construct(
        KurikulumRepository $kurikulumRepository,
        RMKRepository $rmkRepository
    )
    {
        $this->kurikulumRepository = $kurikulumRepository;
        $this->rmkRepository = $rmkRepository;
    }

    public function execute(KelolaMataKuliahKurikulumRequest $request)
    {
        $kurikulum = $this->kurikulumRepository->byId($request->kurikulumId);
        if(empty($kurikulum)) {
            throw new KurikulumNotFoundException("Kurikulum  {$request->kurikulumId->id()} tidak dapat ditemukan");
        }

        $mataKuliah = $this->kurikulumRepository->fetchMataKuliahById($kurikulum->getId(), $request->mataKuliahId);
        $rmk = $this->rmkRepository->byKode($request->kodeRMK);

        if(empty($mataKuliah)) {
            $mataKuliah = new MataKuliah(
                new MataKuliahId(),
                $rmk,
                $request->kodeMataKuliah,
                new NamaBilingual(
                    $request->namaIndonesia,
                    $request->namaInggris
                ),
                $request->deskripsi,
                $request->sks,
                new SifatMataKuliah(
                    $request->sifat
                ),
                $request->semester
            );
        }
        else{
            $mataKuliah->setSks($request->sks);
            $mataKuliah->setSemester($request->semester);
            $mataKuliah->setSifat(new SifatMataKuliah($request->sifat));
        }

        $kurikulum->kelolaMataKuliah($mataKuliah);

        $this->kurikulumRepository->save($kurikulum);
    }


}