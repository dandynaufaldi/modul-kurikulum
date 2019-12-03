<?php
declare(strict_types=1);

use \PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Siakad\Kurikulum\Domain\Model\KurikulumId;

class IdeaIdTest extends TestCase
{
    public function testCanBeInstantiated() : void
    {
        $kurikulumId = new KurikulumId();

        $this->assertInstanceOf(KurikulumId::class, $kurikulumId);
    }

    public function testCanGenerateOwnUuidOnNull() : void
    {
        $kurikulumId = new KurikulumId();

        $this->assertTrue(Uuid::isValid($kurikulumId->id()));
    }

    public function testCanHoldSuppliedUuid() : void
    {
        $kurikulumId = new KurikulumId('7f692713-9d7d-47b0-988d-96e40e8afb54');

        $this->assertEquals('7f692713-9d7d-47b0-988d-96e40e8afb54', $kurikulumId->id());
    }

}