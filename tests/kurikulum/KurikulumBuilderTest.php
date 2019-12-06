<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Siakad\Kurikulum\Domain\Model\Kurikulum;
use Siakad\Kurikulum\Domain\Model\KurikulumBuilder;
use Siakad\Kurikulum\Domain\Model\KurikulumId;
use Siakad\Kurikulum\Domain\Model\MissingBuilderStepException;
use Siakad\Kurikulum\Domain\Model\NamaBilingual;
use Siakad\Kurikulum\Domain\Model\PeriodeTahun;
use Siakad\Kurikulum\Domain\Model\ProgramStudi;
use Siakad\Kurikulum\Domain\Model\Semester;
use Siakad\Kurikulum\Domain\Model\Tahun;
use Siakad\Kurikulum\Domain\Model\User;
use Siakad\Kurikulum\Domain\Model\UserRole;

class KurikulumBuilderTest extends TestCase
{
    protected static $prodi;
    protected static $nama;
    protected static $id;
    protected static $periode;
    protected static $semesterMulai;

    public static function setUpBeforeClass(): void
    {
        self::$nama = new NamaBilingual('Kurikulum 2018', '2018 Curriculum');
        $kaprodi = new User(
            0,
            '5116100011',
            'John Doe',
            UserRole::make(UserRole::$LEVEL_KAPRODI)
        );
        self::$prodi = new ProgramStudi(
            $kaprodi,
            '51100',
            new NamaBilingual('Informatika', 'Informatics')
        );
        self::$id = new KurikulumId();
        self::$periode = new PeriodeTahun(new Tahun(2018), new Tahun(2021));
        self::$semesterMulai = new Semester('ganjil');
    }

    public function testCanBeInstantiated() : void
    {
        $builder = Kurikulum::builder();

        $this->assertInstanceOf(KurikulumBuilder::class, $builder);
    }

    public function testCanBuildKurikulum() : void
    {
        $builder = Kurikulum::builder();
        $kurikulum = $builder
                    ->id(self::$id)
                    ->prodi(self::$prodi)
                    ->nama(self::$nama)
                    ->sksLulus(144)
                    ->sksWajib(120)
                    ->sksPilihan(24)
                    ->semesterNormal(8)
                    ->periode(self::$periode)
                    ->semesterMulai(self::$semesterMulai)
                    ->build();

        $this->assertInstanceOf(Kurikulum::class, $kurikulum);
    }

    public function testCantBuildKurikulumWithMissingStep() : void
    {
        $this->expectException(MissingBuilderStepException::class);

        $builder = Kurikulum::builder();
        $kurikulum = $builder
                    ->id(self::$id)
                    ->prodi(self::$prodi)
                    // ->nama(self::$nama)
                    ->sksLulus(144)
                    ->sksWajib(120)
                    ->sksPilihan(24)
                    ->semesterNormal(8)
                    ->periode(self::$periode)
                    ->semesterMulai(self::$semesterMulai)
                    ->build();
    }
}