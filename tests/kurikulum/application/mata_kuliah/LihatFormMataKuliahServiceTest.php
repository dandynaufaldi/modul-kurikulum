<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Siakad\Kurikulum\Application\LihatFormMataKuliahRequest;
use Siakad\Kurikulum\Application\LihatFormMataKuliahResponse;
use Siakad\Kurikulum\Application\LihatFormMataKuliahService;
use Siakad\Kurikulum\Application\MataKuliahNotFoundException;
use Siakad\Kurikulum\Domain\Model\MataKuliah;
use Siakad\Kurikulum\Domain\Model\MataKuliahId;
use Siakad\Kurikulum\Domain\Model\MataKuliahRepository;
use Siakad\Kurikulum\Domain\Model\NamaBilingual;
use Siakad\Kurikulum\Domain\Model\RMK;
use Siakad\Kurikulum\Domain\Model\RMKId;
use Siakad\Kurikulum\Domain\Model\RMKRepository;
use Siakad\Kurikulum\Domain\Model\User;
use Siakad\Kurikulum\Domain\Model\UserRole;

class LihatFormMataKuliahServiceTest extends TestCase
{
    protected $rmkRepository;
    protected $mataKuliahRepository;

    protected function setUp() : void
    {
        $this->rmkRepository = $this->getMockBuilder(RMKRepository::class)
                                          ->disableOriginalConstructor()
                                          ->getMock();

        $this->mataKuliahRepository = $this->getMockBuilder(MataKuliahRepository::class)
                                             ->disableOriginalConstructor()
                                             ->getMock();
    }

    public function testCanBeInstantiated() : void
    {
        $service = new LihatFormMataKuliahService(
            $this->rmkRepository,
            $this->mataKuliahRepository
        );

        $this->assertInstanceOf(LihatFormMataKuliahService::class, $service);
    }

    protected function createMataKuliahDummy() : MataKuliah
    {
        $nama = new NamaBilingual('Konstruksi Perangkat Lunak', 'Software Construction');
        $id = new MataKuliahId('1');
        $dosen = new User(
            0,
            '5116100011',
            'John Doe',
            UserRole::make(UserRole::$LEVEL_DOSEN)
        );
        $rmkId = new RMKId('123');
        $namaRmk = new NamaBilingual('Rekayasa Perangkat Lunak', 'Software Construction');
        $rmk = new RMK(
            $rmkId,
            '51100',
            $namaRmk,
            $dosen);
        $kode = 'IF184000';
        $deskripsi = 'Mata kuliah mengenai konstruksi perangkat lunak';

        $matakuliah = new MataKuliah($id, $rmk, $kode, $nama, $deskripsi);

        return $matakuliah;
    }

    public function testCanExecuteWithMataKuliahId() : void
    {
        $dummyMataKuliah = $this->createMataKuliahDummy();
        $this->mataKuliahRepository->expects($this->once())
                                  ->method('byId')
                                  ->with($this->anything())
                                  ->will($this->returnValue($dummyMataKuliah));
        $this->rmkRepository->expects($this->once())
                                     ->method('all')
                                     ->will($this->returnValue([]));
        
        $service = new LihatFormMataKuliahService(
            $this->rmkRepository,
            $this->mataKuliahRepository
        );
        
        $dummyRequest = new LihatFormMataKuliahRequest('1');
        $response = $service->execute($dummyRequest);
        
        $expectedResponse = new LihatFormMataKuliahResponse($dummyMataKuliah);
        
        $this->assertInstanceOf(LihatFormMataKuliahResponse::class, $response);
        $this->assertEquals($expectedResponse, $response);
    }

    public function testCanExecuteWithoutMataKuliahId() : void
    {
        $this->mataKuliahRepository->expects($this->never())
                                  ->method('byId');
        $this->rmkRepository->expects($this->once())
                                     ->method('all')
                                     ->will($this->returnValue([]));
                                     
        $service = new LihatFormMataKuliahService(
            $this->rmkRepository,
            $this->mataKuliahRepository
        );

        $dummyRequest = new LihatFormMataKuliahRequest();
        $response = $service->execute($dummyRequest);
        $expectedResponse = new LihatFormMataKuliahResponse();

        $this->assertInstanceOf(LihatFormMataKuliahResponse::class, $response);
        $this->assertEquals($expectedResponse, $response);
    }

    public function testCantBeExecutedOnMataKuliahNotExist() : void
    {
        $this->expectException(MataKuliahNotFoundException::class);

        $this->mataKuliahRepository->expects($this->once())
                                  ->method('byId')
                                  ->with($this->anything())
                                  ->will($this->returnValue(null));
        $this->rmkRepository->expects($this->once())
                                     ->method('all')
                                     ->will($this->returnValue([]));

        $service = new LihatFormMataKuliahService(
            $this->rmkRepository,
            $this->mataKuliahRepository
        );
        
        $dummyRequest = new LihatFormMataKuliahRequest('1');
        $response = $service->execute($dummyRequest);
    }
}