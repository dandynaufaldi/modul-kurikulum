<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Siakad\Kurikulum\Application\LihatDaftarMataKuliahResponse;
use Siakad\Kurikulum\Application\LihatDaftarMataKuliahService;
use Siakad\Kurikulum\Domain\Model\MataKuliah;
use Siakad\Kurikulum\Domain\Model\MataKuliahId;
use Siakad\Kurikulum\Domain\Model\MataKuliahRepository;
use Siakad\Kurikulum\Domain\Model\NamaBilingual;
use Siakad\Kurikulum\Domain\Model\RMK;
use Siakad\Kurikulum\Domain\Model\User;
use Siakad\Kurikulum\Domain\Model\UserRole;

class LihatDaftarMataKuliahServiceTest extends TestCase
{
    protected $mataKuliahRepository;
    protected $countMataKuliah;

    protected function setUp() : void
    {
        $this->countMataKuliah = 5;
        $this->mataKuliahRepository = $this->getMockBuilder(MataKuliahRepository::class)
                                          ->disableOriginalConstructor()
                                          ->getMock();
    }

    public function testCanBeInstantiated() : void
    {
        $service = new LihatDaftarMataKuliahService($this->mataKuliahRepository);

        $this->assertInstanceOf(LihatDaftarMataKuliahService::class, $service);
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
        $rmk = new RMK('51100', 'Rekayasa Perangkat Lunak', $dosen);
        $kode = 'IF184000';
        $deskripsi = 'Mata kuliah mengenai konstruksi perangkat lunak';

        $matakuliah = new MataKuliah($id, $rmk, $kode, $nama, $deskripsi);

        return $matakuliah;
    }

    protected function createDummyMataKuliahArray() : array
    {
        $listMataKuliah = array();
        for ($i=0; $i < $this->countMataKuliah; $i++) {
            $mataKuliah = $this->createMataKuliahDummy();
            $listMataKuliah[] = $mataKuliah;
        }
        return $listMataKuliah;
    }

    protected function createDummyResponse() : LihatDaftarMataKuliahResponse
    {
        $response = new LihatDaftarMataKuliahResponse();
        $listMataKuliah = $this->createDummyMataKuliahArray();
        
        foreach ($listMataKuliah as $mataKuliah) {
            $response->addMataKuliah($mataKuliah);
        }
        return $response;
    }

    public function testCanExecute() : void
    {
        $listMataKuliah = $this->createDummyMataKuliahArray();
        $this->mataKuliahRepository->expects($this->once())
                                  ->method('all')
                                  ->will($this->returnValue($listMataKuliah));
        
        $service = new LihatDaftarMataKuliahService($this->mataKuliahRepository);
        $response = $service->execute();
        $expected = $this->createDummyResponse();

        $this->assertEquals($expected, $response);
    }
}