<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Siakad\Kurikulum\Application\ViewFormCreateKurikulumResponse;
use Siakad\Kurikulum\Application\ViewFormCreateKurikulumService;
use Siakad\Kurikulum\Domain\Model\ProgramStudiRepository;

class ViewFormCreateKurikulumServiceTest extends TestCase
{
    protected $programStudiRepository;

    protected function setUp() : void
    {
        $this->programStudiRepository = $this->getMockBuilder(ProgramStudiRepository::class)
                                             ->disableOriginalConstructor()
                                             ->getMock();
    }
    
    public function testCanBeInstantiated() : void
    {
        $service = new ViewFormCreateKurikulumService($this->programStudiRepository);

        $this->assertInstanceOf(ViewFormCreateKurikulumService::class, $service);
    }

    public function testCanReturnResponse() : void
    {
        $this->programStudiRepository->expects($this->any())
                                     ->method('all')
                                     ->will($this->returnValue([]));
        $service = new ViewFormCreateKurikulumService($this->programStudiRepository);
        $response = $service->execute();
        $expected = new ViewFormCreateKurikulumResponse();
        
        $this->assertEquals($expected, $response);
    }
}