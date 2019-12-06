<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Siakad\Kurikulum\Application\CreateKurikulumRequest;
use Siakad\Kurikulum\Application\CreateKurikulumService;
use Siakad\Kurikulum\Application\ProgramStudiNotFoundException;
use Siakad\Kurikulum\Domain\Model\KurikulumRepository;
use Siakad\Kurikulum\Domain\Model\NamaBilingual;
use Siakad\Kurikulum\Domain\Model\ProgramStudi;
use Siakad\Kurikulum\Domain\Model\ProgramStudiRepository;
use Siakad\Kurikulum\Domain\Model\UnrecognizedSemesterException;
use Siakad\Kurikulum\Domain\Model\User;
use Siakad\Kurikulum\Domain\Model\UserRole;

class CreateKurikulumServiceTest extends TestCase
{
    protected $programStudiRepository;
    protected $kurikulumRepository;
    protected $programStudi;

    protected function setUp() : void
    {
        $this->programStudiRepository = $this->getMockBuilder(ProgramStudiRepository::class)
                                             ->disableOriginalConstructor()
                                             ->getMock();
        $this->kurikulumRepository = $this->getMockBuilder(KurikulumRepository::class)
                                          ->disableOriginalConstructor()
                                          ->getMock();
        $this->programStudi = new ProgramStudi(
            new User(0, '5116100011', 'John Doe', UserRole::make(UserRole::$LEVEL_KAPRODI)),
            '51',
            new NamaBilingual('Informatika', 'Informatics')
        );
    }

    protected function createRequest() : CreateKurikulumRequest
    {
        return new CreateKurikulumRequest(
            $this->programStudi->kode(),
            $this->programStudi->nama()->indonesia(),
            $this->programStudi->nama()->inggris(),
            1,
            1,
            1,
            2,
            2018,
            2021,
            'genap'
        );
    }

    protected function createRequestInvalidPeriode() : CreateKurikulumRequest
    {
        return new CreateKurikulumRequest(
            $this->programStudi->kode(),
            $this->programStudi->nama()->indonesia(),
            $this->programStudi->nama()->inggris(),
            1,
            1,
            1,
            2,
            2021,
            2018,
            'genap'
        );
    }

    protected function createRequestInvalidSemesterMulai() : CreateKurikulumRequest
    {
        return new CreateKurikulumRequest(
            $this->programStudi->kode(),
            $this->programStudi->nama()->indonesia(),
            $this->programStudi->nama()->inggris(),
            1,
            1,
            1,
            2,
            2018,
            2021,
            'geap'
        );
    }

    public function testCanBeInstantiated() : void
    {
        $service = new CreateKurikulumService(
            $this->programStudiRepository,
            $this->kurikulumRepository
        );

        $this->assertInstanceOf(CreateKurikulumService::class, $service);
    }

    public function testCanExecute() : void
    {
        $this->programStudiRepository->expects($this->once())
                                     ->method('byKode')
                                     ->with($this->anything())
                                     ->will($this->returnValue($this->programStudi));
        $this->kurikulumRepository->expects($this->once())
                                  ->method('save')
                                  ->with($this->anything());
        $request = $this->createRequest();
        $service = new CreateKurikulumService(
            $this->programStudiRepository,
            $this->kurikulumRepository
        );
        $service->execute($request);
    }

    public function testCantExecuteOnProgramStudiNotExist() : void
    {
        $this->expectException(ProgramStudiNotFoundException::class);
        
        $this->kurikulumRepository->expects($this->never())
                                  ->method('save')
                                  ->with($this->anything());
        $request = $this->createRequest();
        $service = new CreateKurikulumService(
            $this->programStudiRepository,
            $this->kurikulumRepository
        );
        $service->execute($request);
    }

    public function testCantExecuteOnInvalidPeriode() : void
    {
        $this->expectException(InvalidArgumentException::class);
        
        $this->programStudiRepository->expects($this->once())
                                     ->method('byKode')
                                     ->with($this->anything())
                                     ->will($this->returnValue($this->programStudi));
        $this->kurikulumRepository->expects($this->never())
                                  ->method('save')
                                  ->with($this->anything());
        $request = $this->createRequestInvalidPeriode();
        $service = new CreateKurikulumService(
            $this->programStudiRepository,
            $this->kurikulumRepository
        );
        $service->execute($request);
    }

    public function testCantExecuteOnInvalidSemesterMulai() : void
    {
        $this->expectException(UnrecognizedSemesterException::class);
        
        $this->programStudiRepository->expects($this->once())
                                     ->method('byKode')
                                     ->with($this->anything())
                                     ->will($this->returnValue($this->programStudi));
        $this->kurikulumRepository->expects($this->never())
                                  ->method('save')
                                  ->with($this->anything());
        $request = $this->createRequestInvalidSemesterMulai();
        $service = new CreateKurikulumService(
            $this->programStudiRepository,
            $this->kurikulumRepository
        );
        $service->execute($request);
    }
}