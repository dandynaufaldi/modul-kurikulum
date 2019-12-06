<?php

namespace Siakad\Kurikulum\Application;

use Siakad\Kurikulum\Domain\Model\Kurikulum;
use Siakad\Kurikulum\Domain\Model\KurikulumRepository;
use Siakad\Kurikulum\Domain\Model\NamaBilingual;
use Siakad\Kurikulum\Domain\Model\PeriodeTahun;
use Siakad\Kurikulum\Domain\Model\ProgramStudiRepository;
use Siakad\Kurikulum\Domain\Model\Semester;
use Siakad\Kurikulum\Domain\Model\Tahun;

class CreateKurikulumService
{
    private $programStudiRepository;
    private $kurikulumRepository;
    
    public function __construct(
        ProgramStudiRepository $programStudiRepository,
        KurikulumRepository $kurikulumRepository
    )
    {
        $this->programStudiRepository = $programStudiRepository;
        $this->kurikulumRepository = $kurikulumRepository;
    }

    public function execute(CreateKurikulumRequest $request)
    {
        $programStudi = $this->programStudiRepository->byKode($request->kodeProgramStudi);
        if (empty($programStudi)) {
            throw new ProgramStudiNotFoundException("Program Studi {$request->kodeProgramStudi} not exist");
        }
        $nama = new NamaBilingual(
            $request->namaIndonesia,
            $request->namaInggris
        );
        $periode = new PeriodeTahun(
            new Tahun($request->tahunMulai),
            new Tahun($request->tahunSelesai)
        );
        $semesterMulai = new Semester($request->semesterMulai);
        $kurikulum = Kurikulum::builder()
                              ->prodi($programStudi)
                              ->nama($nama)
                              ->periode($periode)
                              ->semesterMulai($semesterMulai)
                              ->sksLulus($request->sksLulus)->sksWajib($request->sksWajib)
                              ->sksPilihan($request->sksPilihan)
                              ->semesterNormal($request->semesterNormal)
                              ->build();
        $this->kurikulumRepository->save($kurikulum);
    }
}