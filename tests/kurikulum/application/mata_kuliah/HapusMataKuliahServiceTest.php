<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Siakad\Kurikulum\Application\HapusMataKuliahRequest;
use Siakad\Kurikulum\Application\HapusMataKuliahService;
use Siakad\Kurikulum\Application\MataKuliahNotFoundException;
use Siakad\Kurikulum\Domain\Model\MataKuliah;
use Siakad\Kurikulum\Domain\Model\MataKuliahId;
use Siakad\Kurikulum\Domain\Model\MataKuliahRepository;
use Siakad\Kurikulum\Domain\Model\NamaBilingual;
use Siakad\Kurikulum\Domain\Model\RMK;
use Siakad\Kurikulum\Domain\Model\RMKId;
use Siakad\Kurikulum\Domain\Model\User;
use Siakad\Kurikulum\Domain\Model\UserRole;

class HapusMataKuliahServiceTest extends TestCase
{
    protected $mataKuliahRepository;

    protected function setUp() : void
    {
        $this->mataKuliahRepository = $this->getMockBuilder(MataKuliahRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testCanBeInstantiated() : void
    {
        $service = new HapusMataKuliahService($this->mataKuliahRepository);

        $this->assertInstanceOf(HapusMataKuliahService::class, $service);
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

    public function testCanExecute() : void
    {
        $kurikulum = $this->createMataKuliahDummy();
        $this->mataKuliahRepository->expects($this->once())
                                  ->method('byId')
                                  ->with($this->anything())
                                  ->will($this->returnValue($kurikulum));
        $this->mataKuliahRepository->expects($this->once())
                                  ->method('delete')
                                  ->with($this->anything());

        $service = new HapusMataKuliahService($this->mataKuliahRepository);
        $request = new HapusMataKuliahRequest('1');
        $service->execute($request);
    }

    public function testCantExecuteOnMataKuliahNoExists() : void
    {
        $this->expectException(MataKuliahNotFoundException::class);

        $this->mataKuliahRepository->expects($this->once())
                                  ->method('byId')
                                  ->with($this->anything())
                                  ->will($this->returnValue(null));
        $this->mataKuliahRepository->expects($this->never())
                                  ->method('delete')
                                  ->with($this->anything());
        
        $service = new HapusMataKuliahService($this->mataKuliahRepository);
        $request = new HapusMataKuliahRequest('1');
        $service->execute($request);
    }
}