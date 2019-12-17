<?php

namespace Siakad\Kurikulum\Infrastructure;

use PDO;
use Exception;
use Phalcon\Db\Column;
use Siakad\Kurikulum\Domain\Model\MataKuliah;
use Siakad\Kurikulum\Domain\Model\MataKuliahId;
use Siakad\Kurikulum\Domain\Model\MataKuliahRepository;
use Siakad\Kurikulum\Domain\Model\NamaBilingual;
use Siakad\Kurikulum\Domain\Model\RMK;
use Siakad\Kurikulum\Domain\Model\RMKId;
use Siakad\Kurikulum\Domain\Model\User;
use Siakad\Kurikulum\Domain\Model\UserRole;

class SqlMataKuliahRepository implements MataKuliahRepository
{
    private static $byId = 'byId';
    private static $all = 'all';
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
        $this->initStatement();
        $this->initTypes();
    }

    private function initStatement()
    {
        $queryAll = 'SELECT 
            mata_kuliah.id as mata_kuliah_id,
            mata_kuliah.kode_matkul as mata_kuliah_kode,
            mata_kuliah.nama as mata_kuliah_nama,
            mata_kuliah.nama_inggris as mata_kuliah_nama_inggris,
            mata_kuliah.deskripsi as mata_kuliah_deskripsi,
            rmk.id as rmk_id,
            rmk.kode_rmk as rmk_kode,
            rmk.nama as rmk_nama,
            rmk.nama_inggris as rmk_nama_inggris,
            user.id as user_id,
            user.nama AS user_nama,
            user.identifier AS user_identifier,
            user.level AS user_level
        FROM mata_kuliah 
            JOIN rmk ON mata_kuliah.id_rmk = rmk.id
            JOIN user ON rmk.id_ketua = user.id
        WHERE mata_kuliah.deleted_at IS NULL';

        $this->statements = [
            self::$all => $this->db->prepare(
                $queryAll
            ),
            self::$byId => $this->db->prepare(
                $queryAll . ' AND mata_kuliah.id = :id'
            ),
            self::$insert => $this->db->prepare(
                'INSERT INTO mata_kuliah (id, id_rmk, kode_matkul, nama, nama_inggris, deskripsi) 
                VALUES (:id, :id_rmk, :kode_matkul, :nama, :nama_inggris, :deskripsi)'
            ),
            self::$update => $this->db->prepare(
                'UPDATE mata_kuliah SET id_rmk = :id_rmk, kode_matkul = :kode_matkul, 
                nama = :nama, nama_inggris = :nama_inggris, deskripsi = :deskripsi 
                WHERE id = :id'
            ),
            self::$delete => $this->db->prepare(
                'UPDATE mata_kuliah SET deleted_at = CURRENT_TIMESTAMP WHERE id = :id;'
            )
        ];
    }

    private function initTypes()
    {
        $this->types = [
            self::$all => [],
            self::$byId => [
                'id' => Column::BIND_PARAM_STR,
            ],
            self::$save => [
                'id' => Column::BIND_PARAM_STR,
                'id_rmk' => Column::BIND_PARAM_STR,
                'kode_matkul' => Column::BIND_PARAM_STR,
                'nama' => Column::BIND_PARAM_STR,
                'nama_inggris' => Column::BIND_PARAM_STR,
                'deskripsi' => Column::BIND_PARAM_STR
            ],
            self::$delete => [
                'id' => Column::BIND_PARAM_STR,
            ]
        ];
    }

    private function arrayToEntity(array $data) : MataKuliah
    {
        $kaprodi = new User(
            intval($data['user_id']),
            $data['user_identifier'],
            $data['user_nama'],
            UserRole::make(intval($data['user_level']))
        );

        $rmk = new RMK(
            new RMKId($data['rmk_id']),
            $data['rmk_kode'],
            new NamaBilingual($data['rmk_nama'], $data['rmk_nama_inggris']),
            $kaprodi
        );

        $mataKuliah = new MataKuliah(
            new MataKuliahId($data['mata_kuliah_id']),
            $rmk,
            $data['mata_kuliah_kode'],
            new NamaBilingual($data['mata_kuliah_nama'], $data['mata_kuliah_nama_inggris']),
            $data['mata_kuliah_deskripsi']
        );

        return $mataKuliah;
    }

    public function byId(MataKuliahId $mataKuliahId): ?MataKuliah
    {
        $statement = $this->statements[self::$byId];
        $type = $this->types[self::$byId];
        $params = [
            'id' => $mataKuliahId->id()
        ];

        $result = $this->db->executePrepared($statement, $params, $type);
        if($result->rowcount() == 0) {
            return null;
        }

        $matakuliah = $this->arrayToEntity($result->fetch(PDO::FETCH_ASSOC));
        return $matakuliah;
    }

    public function all(): array
    {
        $listMataKuliah = array();
        $statement = $this->statements[self::$all];
        $type = $this->types[self::$all];
        $params = [];

        $result = $this->db->executePrepared($statement, $params, $type);
        $listResultAssoc = $result->fetchAll(PDO::FETCH_ASSOC);

        foreach ($listResultAssoc as $resultAssoc) {
            $mataKuliah = $this->arrayToEntity($resultAssoc);
            $listMataKuliah[] = $mataKuliah;
        }

        return $listMataKuliah;
    }

    public function save(MataKuliah $mataKuliah): void
    {
        $existing = $this->byId($mataKuliah->getId());
        if (empty($existing)) {
            $statement = $this->statements[self::$insert];
        } else {
            $statement = $this->statements[self::$update];
        }
        $type = $this->types[self::$save];
        $params = [
            'id' => $mataKuliah->getId()->id(),
            'id_rmk' => $mataKuliah->getRmk()->id()->id(),
            'kode_matkul' => $mataKuliah->getKode(),
            'nama' => $mataKuliah->getNama()->indonesia(),
            'nama_inggris' => $mataKuliah->getNama()->inggris(),
            'deskripsi' => $mataKuliah->getDeskripsi()
        ];

        $success = $this->db->executePrepared($statement, $params, $type);
        if(!$success) {
            throw new Exception('Failed to save mata kuliah');
        }
    }

    public function delete(MataKuliahId $mataKuliahId): void
    {
        $statement = $this->statements[self::$delete];
        $type = $this->types[self::$delete];
        $params = [
            'id' => $mataKuliahId->id()
        ];
        $success = $this->db->executePrepared($statement, $params, $type);
        if(!$success) {
            throw new Exception('Failed to delete matakuliah');
        }
    }
}