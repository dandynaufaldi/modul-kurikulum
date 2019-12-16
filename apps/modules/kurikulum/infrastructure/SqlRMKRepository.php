<?php

namespace Siakad\Kurikulum\Infrastructure;

use PDO;
use Phalcon\Db\Column;
use Siakad\Kurikulum\Domain\Model\NamaBilingual;
use Siakad\Kurikulum\Domain\Model\RMK;
use Siakad\Kurikulum\Domain\Model\RMKId;
use Siakad\Kurikulum\Domain\Model\RMKRepository;
use Siakad\Kurikulum\Domain\Model\User;
use Siakad\Kurikulum\Domain\Model\UserRole;

class SqlRMKRepository implements RMKRepository
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
            rmk.id AS rmk_id,
            rmk.id_kurikulum AS rmk_id_kurikulum,
            rmk.id_ketua AS rmk_id_ketua,
            rmk.kode_rmk AS rmk_kode,
            rmk.nama AS rmk_nama_indonesia,
            rmk.nama_inggris AS rmk_nama_inggris,
            user.id as user_id,
            user.nama AS user_nama,
            user.identifier AS user_identifier,
            user.level AS user_level
        FROM rmk
        JOIN user ON rmk.id_ketua = user.id';

        $this->statements = [
            self::$all => $this->db->prepare(
                $queryAll
            ),
            self::$byKode => $this->db->prepare(
                $queryAll . ' WHERE prodi.kode = :kode'
            ),
        ];
    }

    private function initTypes()
    {
        $this->types = [
            self::$all => [],
            
            self::$byKode => [
                'kode' => Column::BIND_PARAM_STR
            ],
        ];
    }

    private function arrayToEntity(array $data) : RMK
    {
        return new RMK(
            new RMKId($data['rmk_id']),
            $data['rmk_kode'],
            new NamaBilingual(
                $data['rmk_nama_indonesia'],
                $data['rmk_nama_inggris']
            ),
            new User(
                $data['user_id'],
                $data['user_identifier'],
                $data['user_nama'],
                new UserRole($data['user_level'])
            )
        );
    }

    public function all(): array
    {
        $listRMK = array();
        $statement = $this->statements[self::$all];
        $type = $this->types[self::$all];
        $params = [];

        $result = $this->db->executePrepared($statement, $params, $type);
        $listResultAssoc = $result->fetchAll(PDO::FETCH_ASSOC);

        foreach ($listResultAssoc as $resultAssoc) {
            $rmk = $this->arrayToEntity($resultAssoc);
            $listRMK[] = $rmk;
        }

        return $listRMK;
    }

    public function byKode(string $kode): RMK
    {
        $statement = $this->statements[self::$byKode];
        $type = $this->types[self::$byKode];
        $params = [
            'kode' => $kode
        ];

        $result = $this->db->executePrepared($statement, $params, $type);
        if ($result->rowCount() == 0) {
            return null;
        }
        
        $rmk = $this->arrayToEntity($result->fetch(PDO::FETCH_ASSOC));
        return $rmk;
    }
}