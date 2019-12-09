<?php

namespace Siakad\Kurikulum\Infrastructure;

use PDO;
use Phalcon\Db\Column;
use Siakad\Kurikulum\Domain\Model\Kurikulum;
use Siakad\Kurikulum\Domain\Model\KurikulumId;
use Siakad\Kurikulum\Domain\Model\KurikulumRepository;
use Siakad\Kurikulum\Domain\Model\NamaBilingual;
use Siakad\Kurikulum\Domain\Model\PeriodeTahun;
use Siakad\Kurikulum\Domain\Model\ProgramStudi;
use Siakad\Kurikulum\Domain\Model\Semester;
use Siakad\Kurikulum\Domain\Model\Tahun;
use Siakad\Kurikulum\Domain\Model\User;
use Siakad\Kurikulum\Domain\Model\UserRole;

class SqlKurikulumRepository implements KurikulumRepository
{
    private static $byId = 'byId';
    private static $all = 'all';
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
            kurikulum.id AS kurikulum_id, 
            kurikulum.aktif AS kurikulum_aktif,
            kurikulum.nama AS kurikulum_nama_indonesia,
            kurikulum.nama_inggris AS kurikulum_nama_inggris,
            kurikulum.sks_lulus AS kurikulum_sks_lulus,
            kurikulum.sks_wajib AS kurikulum_sks_wajib,
            kurikulum.sks_pilihan AS kurikulum_sks_pilihan,
            kurikulum.semester_normal AS kurikulum_semester_normal,
            kurikulum.tahun_mulai AS kurikulum_tahun_mulai,
            kurikulum.tahun_selesai AS kurikulum_tahun_selesai,
            kurikulum.semester AS kurikulum_semester_mulai,
            prodi.id AS prodi_id,
            prodi.kode AS prodi_kode,
            prodi.nama AS prodi_nama_indonesia,
            prodi.nama_inggris AS prodi_nama_inggris,
            user.id as user_id,
            user.nama AS user_nama,
            user.identifier AS user_identifier,
            user.level AS user_level
        FROM kurikulum 
            JOIN prodi ON kurikulum.id_prodi = prodi.id 
            JOIN user ON user.id = prodi.id
        WHERE kurikulum.deleted_at IS NULL';
        
        $this->statements = [
            self::$all => $this->db->prepare(
                $queryAll
            ),
            self::$byId => $this->db->prepare(
                $queryAll . ' AND kurikulum.id = :id'
            ),
            self::$insert => $this->db->prepare(
                'INSERT INTO kurikulum
                (id, id_prodi, aktif, nama, nama_inggris, 
                sks_lulus, sks_wajib, sks_pilihan, semester_normal,
                tahun_mulai, tahun_selesai, semester)
                VALUES
                (:id, :id_prodi, :aktif, :nama_indonesia, :nama_inggris, 
                :sks_lulus, :sks_wajib, :sks_pilihan, :semester_normal,
                :tahun_mulai, :tahun_selesai, :semester_mulai)'
            ),
            self::$update => $this->db->prepare(
                'UPDATE kurikulum
                SET id_prodi = :id_prodi, aktif = :aktif, nama = :nama_indonesia,
                nama_inggris = :nama_inggris, sks_lulus = :sks_lulus,
                sks_wajib = :sks_wajib, sks_pilihan = :sks_pilihan, 
                semester_normal = :semester_normal, tahun_mulai = :tahun_mulai,
                tahun_selesai = :tahun_selesai, semester = :semester_mulai
                WHERE id = :id'
            ),
            self::$delete => $this->db->prepare(
                'UPDATE kurikulum
                SET deleted_at = CURRENT_TIMESTAMP
                WHERE id = :id'
            )
        ];
    }

    private function initTypes()
    {
        $allColumn = [
            'id' => Column::BIND_PARAM_STR,
            'id_prodi' => Column::BIND_PARAM_INT,
            'aktif' => Column::BIND_PARAM_BOOL,
            'nama_indonesia' => Column::BIND_PARAM_STR,
            'nama_inggris' => Column::BIND_PARAM_STR,
            'sks_lulus' => Column::BIND_PARAM_INT,
            'sks_wajib' => Column::BIND_PARAM_INT,
            'sks_pilihan' => Column::BIND_PARAM_INT,
            'semester_normal'=> Column::BIND_PARAM_INT,
            'tahun_mulai' => Column::BIND_PARAM_INT,
            'tahun_selesai' => Column::BIND_PARAM_INT,
            'semester_mulai' => Column::BIND_PARAM_STR
        ];
        $this->types = [
            self::$all => [],
            self::$byId => [
                'id' => Column::BIND_PARAM_STR
            ],
            self::$insert => $allColumn,
            self::$update => $allColumn,
            self::$delete => [
                'id' => Column::BIND_PARAM_STR
            ]
        ];
    }

    private function arrayToEntity(array $data) : Kurikulum
    {
        $kaprodi = new User(
            intval($data['user_id']),
            $data['user_identifier'],
            $data['user_nama'],
            UserRole::make(intval($data['user_level']))
        );
        $prodi = new ProgramStudi(
            $kaprodi,
            $data['prodi_kode'],
            new NamaBilingual(
                $data['prodi_nama_indonesia'],
                $data['prodi_nama_inggris']
            )
        );
        $aktif = boolval(intval($data['kurikulum_aktif']));
        $kurikulum = Kurikulum::builder()
                    ->id(new KurikulumId($data['kurikulum_id']))
                    ->prodi($prodi)
                    ->nama(new NamaBilingual(
                        $data['kurikulum_nama_indonesia'],
                        $data['kurikulum_nama_inggris']
                    ))
                    ->sksLulus(intval($data['kurikulum_sks_lulus']))
                    ->sksWajib(intval($data['kurikulum_sks_wajib']))
                    ->sksPilihan(intval($data['kurikulum_sks_pilihan']))
                    ->semesterNormal(intval($data['kurikulum_semester_normal']))
                    ->periode(new PeriodeTahun(
                        new Tahun(intval($data['kurikulum_tahun_mulai'])),
                        new Tahun(intval($data['kurikulum_tahun_selesai']))
                    ))
                    ->semesterMulai(new Semester($data['kurikulum_semester_mulai']))
                    ->build();
        if ($aktif) {
            $kurikulum->aktif();
        }
        return $kurikulum;
    }

    public function all(): array
    {
        $listKurikulum = array();
        $statement = $this->statements[self::$all];
        $type = $this->types[self::$all];
        $params = [];

        $result = $this->db->executePrepared($statement, $params, $type);
        $listResultAssoc = $result->fetchAll(PDO::FETCH_ASSOC);

        foreach ($listResultAssoc as $resultAssoc) {
            $kurikulum = $this->arrayToEntity($resultAssoc);
            $listKurikulum[] = $kurikulum;
        }

        return $listKurikulum;
    }

    public function byId(KurikulumId $kurikulumId): ?Kurikulum
    {
        $statement = $this->statements[self::$byId];
        $type = $this->types[self::$byId];
        $params = [
            'id' => $kurikulumId->id()
        ];
        $result = $this->db->executePrepared($statement, $params, $type);
        if ($result->rowCount() == 0) {
            return null;
        }
        $kurikulum = $this->arrayToEntity($result->fetch(PDO::FETCH_ASSOC));
        return $kurikulum;
    }

    public function save(Kurikulum $kurikulum): void
    {
        
    }

    public function delete(KurikulumId $kurikulumId): void
    {
        
    }
}