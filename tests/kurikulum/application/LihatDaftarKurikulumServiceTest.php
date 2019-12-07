<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Siakad\Kurikulum\Application\LihatDaftarKurikulumResponse;
use Siakad\Kurikulum\Application\LihatDaftarKurikulumService;
use Siakad\Kurikulum\Domain\Model\Kurikulum;
use Siakad\Kurikulum\Domain\Model\KurikulumId;
use Siakad\Kurikulum\Domain\Model\KurikulumRepository;
use Siakad\Kurikulum\Domain\Model\NamaBilingual;
use Siakad\Kurikulum\Domain\Model\PeriodeTahun;
use Siakad\Kurikulum\Domain\Model\ProgramStudi;
use Siakad\Kurikulum\Domain\Model\Semester;
use Siakad\Kurikulum\Domain\Model\Tahun;
use Siakad\Kurikulum\Domain\Model\User;
use Siakad\Kurikulum\Domain\Model\UserRole;

class LihatDaftarKurikulumServiceTest extends TestCase
{
    protected $kurikulumRepository;
    protected $countKurikulum;

    protected function setUp() : void
    {
        $this->countKurikulum = 5;
        $this->kurikulumRepository = $this->getMockBuilder(KurikulumRepository::class)
                                          ->disableOriginalConstructor()
                                          ->getMock();
    }

    public function testCanBeInstantiated() : void
    {
        $service = new LihatDaftarKurikulumService($this->kurikulumRepository);

        $this->assertInstanceOf(LihatDaftarKurikulumService::class, $service);
    }

    protected function createKurikulumDummy() : Kurikulum
    {
        $nama = new NamaBilingual('Kurikulum 2018', '2018 Curriculum');
        $kaprodi = new User(
            0,
            '5116100011',
            'John Doe',
            UserRole::make(UserRole::$LEVEL_KAPRODI)
        );
        $prodi = new ProgramStudi(
            $kaprodi,
            '51100',
            new NamaBilingual('Informatika', 'Informatics')
        );
        $id = new KurikulumId('1');
        $periode = new PeriodeTahun(new Tahun(2018), new Tahun(2021));
        $semesterMulai = new Semester('ganjil');
        $builder = Kurikulum::builder();
        $kurikulum = $builder
                    ->id($id)
                    ->prodi($prodi)
                    ->nama($nama)
                    ->sksLulus(144)
                    ->sksWajib(120)
                    ->sksPilihan(24)
                    ->semesterNormal(8)
                    ->periode($periode)
                    ->semesterMulai($semesterMulai)
                    ->build();
        return $kurikulum;
    }

    protected function createDummyKurikulumArray() : array
    {
        $listKurikulum = array();
        for ($i=0; $i < $this->countKurikulum; $i++) { 
            $kurikulum = $this->createKurikulumDummy();
            $listKurikulum[] = $kurikulum;
        }
        return $listKurikulum;
    }

    protected function createDummyResponse() : LihatDaftarKurikulumResponse
    {
        $response = new LihatDaftarKurikulumResponse();
        $listKurikulum = $this->createDummyKurikulumArray();
        
        foreach ($listKurikulum as $kurikulum) {
            $response->addKurikulum($kurikulum);
        }
        return $response;
    }

    public function testCanExecute() : void
    {
        $listKurikulum = $this->createDummyKurikulumArray();
        $this->kurikulumRepository->expects($this->once())
                                  ->method('all')
                                  ->will($this->returnValue($listKurikulum));
        
        $service = new LihatDaftarKurikulumService($this->kurikulumRepository);
        $response = $service->execute();
        $expected = $this->createDummyResponse();

        $this->assertEquals($expected, $response);
    }
}