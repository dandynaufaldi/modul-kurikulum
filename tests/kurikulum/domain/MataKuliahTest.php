<?php


use PHPUnit\Framework\TestCase;
use Siakad\Kurikulum\Domain\Model\MataKuliah;
use Siakad\Kurikulum\Domain\Model\MataKuliahId;
use Siakad\Kurikulum\Domain\Model\NamaBilingual;
use Siakad\Kurikulum\Domain\Model\RMK;
use Siakad\Kurikulum\Domain\Model\User;
use Siakad\Kurikulum\Domain\Model\UserRole;

class MataKuliahTest extends TestCase
{
    protected static $id;
    protected static $rmk;
    protected static $nama;
    protected static $deskripsi;

    public static function setUpBeforeClass() : void
    {
        self::$id = new MataKuliahId();

        $dosen = new User(
            0,
            '5116100011',
            'John Doe',
            UserRole::make(UserRole::$LEVEL_DOSEN)
        );
        self::$rmk = new RMK(
            '51100',
            'RMK Satu',
            $dosen
        );

        self::$nama = new NamaBilingual(
            'Konstruksi Perangkat Lunak',
            'Software Construction'
        );

        self::$deskripsi = 'Matakuliah yang belajar mengenai konstruksi perangkat lunak';
    }

    public function testCanBeInstantiated()
    {
        $mataKuliah = new MataKuliah(self::$id, self::$rmk, '51100', self::$nama, self::$deskripsi);
        $this->assertInstanceOf(MataKuliah::class, $mataKuliah);
    }

}
