<?php
declare(strict_types=1);

use \PHPUnit\Framework\TestCase;
use Siakad\Kurikulum\Domain\Model\PeriodeTahun;
use Siakad\Kurikulum\Domain\Model\Tahun;

class PeriodeTahunTest extends TestCase
{
    public function testCanBeInstantiated() : void
    {
        $mulai = new Tahun(2014);
        $seleai = new Tahun(2018);
        $periode = new PeriodeTahun($mulai, $seleai);

        $this->assertInstanceOf(PeriodeTahun::class, $periode);
    }

    public function testCantBeInstantiatedWithInvalidRange() : void
    {
        $this->expectException(InvalidArgumentException::class);
        
        $mulai = new Tahun(2018);
        $seleai = new Tahun(2014);
        $periode = new PeriodeTahun($mulai, $seleai);
    }
}