<?php
declare(strict_types=1);

use \PHPUnit\Framework\TestCase;
use Siakad\Kurikulum\Domain\Model\NamaBilingual;

class NamaBilingualTest extends TestCase
{
    public function testCanBeInstantiated() : void
    {
        $indonesia = 'Informatika';
        $inggris = 'Informatics';
        $nama = new NamaBilingual($indonesia, $inggris);
        
        $this->assertEquals($indonesia, $nama->indonesia());
        $this->assertEquals($inggris, $nama->inggris());
    }
}