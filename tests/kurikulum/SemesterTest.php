<?php
declare(strict_types=1);

use \PHPUnit\Framework\TestCase;
use Siakad\Kurikulum\Domain\Model\Semester;

class SemesterTest extends TestCase
{

    public function testCanBeInstantiated() : void
    {
        $genap = new Semester('genap');
        $ganjil = new Semester('ganjil');
        
        $this->assertEquals('genap', $genap->semester());
        $this->assertEquals('ganjil', $ganjil->semester());
    }

    public function testAcceptNotLowerCase() : void
    {
        $genap = new Semester('Genap');
        $ganjil = new Semester('Ganjil');
        
        $this->assertEquals('genap', $genap->semester());
        $this->assertEquals('ganjil', $ganjil->semester());
    }

    public function testInvalidArgument()
    {
        $this->expectException(InvalidArgumentException::class);
        
        $semester = new Semester('1');
    }

    public function testCompareEqual()
    {
        $semester1 = new Semester('genap');
        $semester2 = new Semester('genap');

        $this->assertTrue($semester1->isEqual($semester2));
    }

    public function testCompareGreater()
    {
        $semester1 = new Semester('ganjil');
        $semester2 = new Semester('genap');

        $this->assertTrue($semester1->isGreater($semester2));
    }
    
}