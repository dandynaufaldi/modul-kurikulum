<?php
declare(strict_types=1);

use \PHPUnit\Framework\TestCase;
use Siakad\Kurikulum\Domain\Model\NamaBilingual;
use Siakad\Kurikulum\Domain\Model\ProgramStudi;
use Siakad\Kurikulum\Domain\Model\User;
use Siakad\Kurikulum\Domain\Model\UserRole;

class ProgramStudiTest extends TestCase
{
    public function testCanBeInstantiated() : void
    {
        $kaprodi = new User(
            0,
            '5116100011',
            'John Doe',
            UserRole::make(UserRole::$LEVEL_KAPRODI)
        );
        $namaProdi = new NamaBilingual(
            'Informatika',
            'Informatics'
        );
        $prodi = new ProgramStudi($kaprodi, '51', $namaProdi);

        $this->assertInstanceOf(ProgramStudi::class, $prodi);
    }

    public function testCantBeInstantiatedWithWrongUserLevel()
    {
        $this->expectException(InvalidArgumentException::class);
        $dosen = new User(
            0,
            '5116100011',
            'John Doe',
            UserRole::make(UserRole::$LEVEL_DOSEN)
        );
        $namaProdi = new NamaBilingual(
            'Informatika',
            'Informatics'
        );
        $prodi = new ProgramStudi($dosen, '51', $namaProdi);
    }
}