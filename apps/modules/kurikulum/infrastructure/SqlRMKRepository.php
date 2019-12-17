<?php

namespace Siakad\Kurikulum\Infrastructure;

use Exception;
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
    private static $byId = 'byId';
    private static $save = 'save';
    private static $insert = 'insert';
    private static $update = 'update';
    private static $delete = 'delete';

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
            rmk.id_ketua AS rmk_id_ketua,
            rmk.kode_rmk AS rmk_kode,
            rmk.nama AS rmk_nama_indonesia,
            rmk.nama_inggris AS rmk_nama_inggris,
            user.id as user_id,
            user.nama AS user_nama,
            user.identifier AS user_identifier,
            user.level AS user_level
        FROM rmk
        JOIN user ON rmk.id_ketua = user.id
        WHERE rmk.deleted_at IS NULL';

        $this->statements = [
            self::$all => $this->db->prepare(
                $queryAll
            ),
            self::$byKode => $this->db->prepare(
                $queryAll . ' AND rmk.kode_rmk = :kode'
            ),
            self::$byId => $this->db->prepare(
                $queryAll . ' AND rmk.id = :id'
            ),
            self::$insert => $this->db->prepare(
                'INSERT INTO rmk
                (id, id_ketua, kode_rmk, nama, nama_inggris)
                VALUES
                (:id, :id_ketua, :kode_rmk, :nama_indonesia, :nama_inggris)'
            ),
            self::$update => $this->db->prepare(
                'UPDATE rmk
                SET id_ketua = :id_ketua, kode_rmk = :kode_rmk,
                nama = :nama_indonesia, nama_inggris = :nama_inggris
                WHERE id = :id'
            ),
            self::$delete => $this->db->prepare(
                'UPDATE rmk
                SET deleted_at = CURRENT_TIMESTAMP
                WHERE id = :id'
            ),
        ];
    }

    private function initTypes()
    {
        $allColumn = [
            'id' => Column::BIND_PARAM_STR,
            'id_ketua' => Column::BIND_PARAM_INT,
            'kode_rmk' => Column::BIND_PARAM_STR,
            'nama_indonesia' => Column::BIND_PARAM_STR,
            'nama_inggris' => Column::BIND_PARAM_STR,
        ];

        $this->types = [
            self::$all => [],
            self::$byKode => [
                'kode' => Column::BIND_PARAM_STR
            ],
            self::$byId => [
                'id' => Column::BIND_PARAM_STR
            ],
            self::$save => $allColumn,
            self::$delete => [
                'id' => Column::BIND_PARAM_STR
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

    public function byId(RMKId $id)
    {
        $statement = $this->statements[self::$byId];
        $type = $this->types[self::$byId];
        $params = [
            'id' => $id->id()
        ];
        
        $result = $this->db->executePrepared($statement, $params, $type);

        if ($result->rowCount() == 0) {
            return null;
        }
        
        $rmk = $this->arrayToEntity($result->fetch(PDO::FETCH_ASSOC));
        
        return $rmk;
    }

    public function byKode(string $kode)
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

    public function save(RMK $rmk)
    {
        $existing = $this->byId($rmk->id());
        if (empty($existing)) {
            $statement = $this->statements[self::$insert];
        } else {
            $statement = $this->statements[self::$update];
        }
        $type = $this->types[self::$save];
        $params = [
            'id' => $rmk->id()->id(),
            'id_ketua' => $rmk->ketua()->id(),
            'kode_rmk' => $rmk->kode(),
            'nama_indonesia' => $rmk->nama()->indonesia(),
            'nama_inggris' => $rmk->nama()->inggris(),
        ];
        $success = $this->db->executePrepared($statement, $params, $type);
        if (!$success) {
            throw new Exception('Failed to save RMK');
        }
    }

    public function delete(RMKId $rmkId)
    {
        $statement = $this->statements[self::$delete];
        $type = $this->types[self::$delete];
        $params = [
            'id' => $rmkId->id()
        ];

        $success = $this->db->executePrepared($statement, $params, $type);
        if (!$success) {
            throw new Exception('Failed to delete RMK');
        }
    }
}