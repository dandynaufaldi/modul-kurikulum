<?php


namespace Siakad\Kurikulum\Domain\Model;


class SifatMataKuliah
{
    public static $wajib = 'wajib';
    public static $pilihan = 'pilihan';

    private $sifat;

    /**
     * SifatMataKuliah constructor.
     * @param $sifat
     * @throws UnrecognizedSifatMataKuliahException
     */
    public function __construct($sifat)
    {
        $sifat = strtolower($sifat);
        if(!SifatMataKuliah::validate($sifat)) {
            throw new UnrecognizedSifatMataKuliahException("Invalid sifat semester value");
        }
        $this->sifat = $sifat;
    }

    public static function validate(string $sifat)
    {
        $value = strtolower($sifat);
        $allowed_value = [
            self::$wajib,
            self::$pilihan,
        ];
        return in_array($value, $allowed_value, true);
    }

    public function sifat()
    {
        return $this->sifat;
    }

}