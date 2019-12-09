<?php

namespace Siakad\Kurikulum\Infrastructure;

use PDO;
use Phalcon\Db\Column;
use Siakad\Kurikulum\Domain\Model\NamaBilingual;
use Siakad\Kurikulum\Domain\Model\ProgramStudi;
use Siakad\Kurikulum\Domain\Model\ProgramStudiRepository;
use Siakad\Kurikulum\Domain\Model\User;
use Siakad\Kurikulum\Domain\Model\UserRole;

class SqlProgramStudiRepository implements ProgramStudiRepository
{
    
    private static $all = 'all';
    private static $byKode = 'byKode';

    private $db;
    private $statements;
    private $types;

    public function __construct($di)
    {
        $this->db = $di->get('db');
        $this->initStatements();
        $this->initTypes();
    }

    private function initStatements()
    {
        $queryAll = 'SELECT 
            prodi.id AS prodi_id,
            prodi.kode AS prodi_kode,
            prodi.nama AS prodi_nama_indonesia,
            prodi.nama_inggris AS prodi_nama_inggris,
            user.id as user_id,
            user.nama AS user_nama,
            user.identifier AS user_identifier,
            user.level AS user_level
        FROM prodi 
            JOIN user ON prodi.id_kaprodi = user.id';
        $this->statements = [
            self::$all => $this->db->prepare(
                $queryAll
            ),
            self::$byKode => $this->db->prepare(
                $queryAll . ' WHERE prodi.kode = :kode'
            )
        ];
    }

    private function initTypes()
    {
        $this->types = [
            self::$all => [],
            self::$byKode => [
                'kode' => Column::BIND_PARAM_STR
            ]
        ];
    }

    private function arrayToEntity(array $data) : ProgramStudi
    {
        $kaprodi = new User(
            intval($data['user_id']),
            $data['user_identifier'],
            $data['user_nama'],
            UserRole::make(intval($data['user_level']))
        );
        return new ProgramStudi(
            $kaprodi,
            $data['prodi_kode'],
            new NamaBilingual(
                $data['prodi_nama_indonesia'],
                $data['prodi_nama_inggris']
            )
        );
    }

    public function all(): array
    {
        $listProdi = array();
        $statement = $this->statements[self::$all];
        $type = $this->types[self::$all];
        $params = [];

        $result = $this->db->executePrepared($statement, $params, $type);
        $listResultAssoc = $result->fetchAll(PDO::FETCH_ASSOC);

        foreach ($listResultAssoc as $resultAssoc) {
            $prodi = $this->arrayToEntity($resultAssoc);
            $listProdi[] = $prodi;
        }

        return $listProdi;
    }

    public function byKode(string $kode): ?ProgramStudi
    {
        return null;
    }
}