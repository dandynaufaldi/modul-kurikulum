<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Siakad\Kurikulum\Application\KurikulumNotFoundException;
use Siakad\Kurikulum\Application\ViewFormEditKurikulumRequest;
use Siakad\Kurikulum\Application\ViewFormEditKurikulumResponse;
use Siakad\Kurikulum\Application\ViewFormEditKurikulumService;
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

class ViewFormEditKurikulumServiceTest extends TestCase
{
    protected $kurikulumRepository;

    protected function setUp() : void
    {
        $this->kurikulumRepository = $this->getMockBuilder(KurikulumRepository::class)
                                          ->disableOriginalConstructor()
                                          ->getMock();
    }

    public function testCanBeInstantiated() : void
    {
        $service = new ViewFormEditKurikulumService($this->kurikulumRepository);

        $this->assertInstanceOf(ViewFormEditKurikulumService::class, $service);
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
        $id = new KurikulumId();
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

    public function testCanExecute() : void
    {
        $dummyKurikulum = $this->createKurikulumDummy();
        $this->kurikulumRepository->expects($this->once())
                                  ->method('byId')
                                  ->with($this->anything())
                                  ->will($this->returnValue($dummyKurikulum));
        
        $service = new ViewFormEditKurikulumService($this->kurikulumRepository);
        $dummyRequest = new ViewFormEditKurikulumRequest('1');
        $response = $service->execute($dummyRequest);
        
        $expectedResponse = new ViewFormEditKurikulumResponse($dummyKurikulum);
        
        $this->assertInstanceOf(ViewFormEditKurikulumResponse::class, $response);
        $this->assertEquals($expectedResponse, $response);
    }

    public function testCantBeExecutedOnKurikulumNotExist() : void
    {
        $this->expectException(KurikulumNotFoundException::class);

        $this->kurikulumRepository->expects($this->once())
                                  ->method('byId')
                                  ->with($this->anything())
                                  ->will($this->returnValue(null));
        
        $service = new ViewFormEditKurikulumService($this->kurikulumRepository);
        $dummyRequest = new ViewFormEditKurikulumRequest('1');
        $response = $service->execute($dummyRequest);
    }
}