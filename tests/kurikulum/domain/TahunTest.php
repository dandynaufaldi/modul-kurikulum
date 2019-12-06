<?php
declare(strict_types=1);

use \PHPUnit\Framework\TestCase;
use Siakad\Kurikulum\Domain\Model\Tahun;

class TahunTest extends TestCase
{
    public function testCanBeInstantiated() : void
    {
        $tahun = new Tahun(2019);
        $this->assertEquals(2019, $tahun->tahun());
    }

    public function testCompareEqual() : void
    {
        $tahun1 = new Tahun(2019);
        $tahun2 = new Tahun(2019);
        $tahun3 = new Tahun(2020);
        
        $this->assertTrue($tahun1->isEqual($tahun2));
        $this->assertFalse($tahun2->isEqual($tahun3));
    }

    public function testCompareGreater() : void
    {
        $tahun1 = new Tahun(2019);
        $tahun2 = new Tahun(2019);
        $tahun3 = new Tahun(2020);

        $this->assertTrue($tahun3->isGreater($tahun2));
        $this->assertFalse($tahun1->isGreater($tahun2));
    }

    public function testNowStatic() : void
    {
        $sekarang = Tahun::now();
        $sekarangDateTime = new DateTime('now');
        $sekarangYear = intval($sekarangDateTime->format('Y'));
        $sekarangTahun = new Tahun($sekarangYear);

        $this->assertEquals($sekarang, $sekarangTahun);
    }
}