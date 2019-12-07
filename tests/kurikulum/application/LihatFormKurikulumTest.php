<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Siakad\Kurikulum\Application\KurikulumNotFoundException;
use Siakad\Kurikulum\Application\LihatFormKurikulumRequest;
use Siakad\Kurikulum\Application\LihatFormKurikulumResponse;
use Siakad\Kurikulum\Application\LihatFormKurikulumService;
use Siakad\Kurikulum\Domain\Model\Kurikulum;
use Siakad\Kurikulum\Domain\Model\KurikulumId;
use Siakad\Kurikulum\Domain\Model\KurikulumRepository;
use Siakad\Kurikulum\Domain\Model\NamaBilingual;
use Siakad\Kurikulum\Domain\Model\PeriodeTahun;
use Siakad\Kurikulum\Domain\Model\ProgramStudi;
use Siakad\Kurikulum\Domain\Model\ProgramStudiRepository;
use Siakad\Kurikulum\Domain\Model\Semester;
use Siakad\Kurikulum\Domain\Model\Tahun;
use Siakad\Kurikulum\Domain\Model\User;
use Siakad\Kurikulum\Domain\Model\UserRole;

class LihatFormKurikulumServiceTest extends TestCase
{
    protected $kurikulumRepository;
    protected $programStudiRepository;

    protected function setUp() : void
    {
        $this->kurikulumRepository = $this->getMockBuilder(KurikulumRepository::class)
                                          ->disableOriginalConstructor()
                                          ->getMock();
        $this->programStudiRepository = $this->getMockBuilder(ProgramStudiRepository::class)
                                             ->disableOriginalConstructor()
                                             ->getMock();
    }

    public function testCanBeInstantiated() : void
    {
        $service = new LihatFormKurikulumService(
            $this->kurikulumRepository,
            $this->programStudiRepository
        );

        $this->assertInstanceOf(LihatFormKurikulumService::class, $service);
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

    public function testCanExecuteWithKurikulumId() : void
    {
        $dummyKurikulum = $this->createKurikulumDummy();
        $this->kurikulumRepository->expects($this->once())
                                  ->method('byId')
                                  ->with($this->anything())
                                  ->will($this->returnValue($dummyKurikulum));
        $this->programStudiRepository->expects($this->once())
                                     ->method('all')
                                     ->will($this->returnValue([]));
        
        $service = new LihatFormKurikulumService(
            $this->kurikulumRepository,
            $this->programStudiRepository
        );
        
        $dummyRequest = new LihatFormKurikulumRequest('1');
        $response = $service->execute($dummyRequest);
        
        $expectedResponse = new LihatFormKurikulumResponse($dummyKurikulum);
        
        $this->assertInstanceOf(LihatFormKurikulumResponse::class, $response);
        $this->assertEquals($expectedResponse, $response);
    }

    public function testCanExecuteWithoutKurikulumId() : void
    {
        $this->kurikulumRepository->expects($this->never())
                                  ->method('byId');
        $this->programStudiRepository->expects($this->once())
                                     ->method('all')
                                     ->will($this->returnValue([]));
                                     
        $service = new LihatFormKurikulumService(
            $this->kurikulumRepository,
            $this->programStudiRepository
        );

        $dummyRequest = new LihatFormKurikulumRequest();
        $response = $service->execute($dummyRequest);
        $expectedResponse = new LihatFormKurikulumResponse();

        $this->assertInstanceOf(LihatFormKurikulumResponse::class, $response);
        $this->assertEquals($expectedResponse, $response);
    }

    public function testCantBeExecutedOnKurikulumNotExist() : void
    {
        $this->expectException(KurikulumNotFoundException::class);

        $this->kurikulumRepository->expects($this->once())
                                  ->method('byId')
                                  ->with($this->anything())
                                  ->will($this->returnValue(null));
        $this->programStudiRepository->expects($this->once())
                                     ->method('all')
                                     ->will($this->returnValue([]));

        $service = new LihatFormKurikulumService(
            $this->kurikulumRepository,
            $this->programStudiRepository
        );
        
        $dummyRequest = new LihatFormKurikulumRequest('1');
        $response = $service->execute($dummyRequest);
    }
}