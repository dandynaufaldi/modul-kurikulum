<?php

namespace Siakad\Kurikulum\Infrastructure;

use Exception;
use PDO;
use Phalcon\Db\Column;
use Siakad\Kurikulum\Domain\Model\Kurikulum;
use Siakad\Kurikulum\Domain\Model\KurikulumId;
use Siakad\Kurikulum\Domain\Model\KurikulumRepository;
use Siakad\Kurikulum\Domain\Model\MataKuliah;
use Siakad\Kurikulum\Domain\Model\MataKuliahId;
use Siakad\Kurikulum\Domain\Model\NamaBilingual;
use Siakad\Kurikulum\Domain\Model\PeriodeTahun;
use Siakad\Kurikulum\Domain\Model\ProgramStudi;
use Siakad\Kurikulum\Domain\Model\RMK;
use Siakad\Kurikulum\Domain\Model\RMKId;
use Siakad\Kurikulum\Domain\Model\Semester;
use Siakad\Kurikulum\Domain\Model\SifatMataKuliah;
use Siakad\Kurikulum\Domain\Model\Tahun;
use Siakad\Kurikulum\Domain\Model\User;
use Siakad\Kurikulum\Domain\Model\UserRole;

class SqlKurikulumRepository implements KurikulumRepository
{
    private static $byId = 'byId';
    private static $all = 'all';
    private static $save = 'save';
    private static $insert = 'insert';
    private static $update = 'update';
    private static $delete = 'delete';
    private static $fetchMataKuliah = 'fetchMataKuliah';
    private static $fetchMataKuliahById = 'fetchMataKuliahById';
    private static $insertMK = 'insertMK';
    private static $addMKKurikulum = 'addMKKurikulum';
    private static $saveMKKurikulum = 'saveMKKurikulum';
    private static $deleteMKKurikulum = 'deleteMKKurikulum';
    private static $updateMKKurikulum = 'updateMKKurikulum';
    
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
            JOIN prodi ON kurikulum.kode_prodi = prodi.kode 
            JOIN user ON user.id = prodi.id_kaprodi
        WHERE kurikulum.deleted_at IS NULL';

        $queryMKKurikulumAll = 'SELECT
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
            user.level AS user_level,
            mk_kurikulum.sks AS mk_kurikulum_sks, 
            mk_kurikulum.sifat AS mk_kurikulum_sifat,
            mk_kurikulum.semester AS mk_kurikulum_semester
        FROM mata_kuliah 
            JOIN rmk ON mata_kuliah.id_rmk = rmk.id
            JOIN user ON rmk.id_ketua = user.id
            JOIN mk_kurikulum ON mata_kuliah.id = mk_kurikulum.id_mk
        WHERE mata_kuliah.deleted_at IS NULL 
        AND mk_kurikulum.deleted_at IS NULL
        AND mk_kurikulum.id_kurikulum = :id_kurikulum';
        
        $this->statements = [
            self::$all => $this->db->prepare(
                $queryAll
            ),
            self::$byId => $this->db->prepare(
                $queryAll . ' AND kurikulum.id = :id'
            ),
            self::$insert => $this->db->prepare(
                'INSERT INTO kurikulum
                (id, kode_prodi, aktif, nama, nama_inggris, 
                sks_lulus, sks_wajib, sks_pilihan, semester_normal,
                tahun_mulai, tahun_selesai, semester)
                VALUES
                (:id, :kode_prodi, :aktif, :nama_indonesia, :nama_inggris, 
                :sks_lulus, :sks_wajib, :sks_pilihan, :semester_normal,
                :tahun_mulai, :tahun_selesai, :semester_mulai)'
            ),
            self::$update => $this->db->prepare(
                'UPDATE kurikulum
                SET kode_prodi = :kode_prodi, aktif = :aktif, nama = :nama_indonesia,
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
            ),
            self::$fetchMataKuliah => $this->db->prepare(
                $queryMKKurikulumAll
            ),
            self::$fetchMataKuliahById => $this->db->prepare(
                $queryMKKurikulumAll . ' AND mk_kurikulum.id_mk = :id_mk'
            ),
            self::$insertMK => $this->db->prepare(
                'INSERT INTO mata_kuliah 
                (id, id_rmk, kode_matkul, nama, nama_inggris, deskripsi) 
                VALUES 
                (:id, :id_rmk, :kode_matkul, :nama, :nama_inggris, :deskripsi)'
            ),
            self::$addMKKurikulum => $this->db->prepare(
                'INSERT INTO mk_kurikulum
                (id_mk, id_kurikulum, sifat, sks, semester)
                VALUES
                (:id_mk, :id_kurikulum, :sifat, :sks, :semester)'
            ),
            self::$deleteMKKurikulum => $this->db->prepare(
                'UPDATE mk_kurikulum
                SET deleted_at = CURRENT_TIMESTAMP
                WHERE id_mk = :id_mk AND id_kurikulum = :id_kurikulum'
            ),
            self::$updateMKKurikulum => $this->db->prepare(
                'UPDATE mk_kurikulum
                SET sifat = :sifat, sks = :sks, semester = :semester
                WHERE id_mk = :id_mk AND id_kurikulum = :id_kurikulum'
            )
        ];
    }

    private function initTypes()
    {
        $allColumn = [
            'id' => Column::BIND_PARAM_STR,
            'kode_prodi' => Column::BIND_PARAM_STR,
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
            self::$save => $allColumn,
            self::$delete => [
                'id' => Column::BIND_PARAM_STR
            ],
            self::$fetchMataKuliah => [
                'id_kurikulum' => Column::BIND_PARAM_STR
            ],
            self::$fetchMataKuliahById => [
                'id_kurikulum' => Column::BIND_PARAM_STR,
                'id_mk' => Column::BIND_PARAM_STR
            ],
            self::$insertMK => [
                'id' => Column::BIND_PARAM_STR,
                'id_rmk' => Column::BIND_PARAM_STR,
                'kode_matkul' => Column::BIND_PARAM_STR,
                'nama' => Column::BIND_PARAM_STR,
                'nama_inggris' => Column::BIND_PARAM_STR,
                'deskripsi' => Column::BIND_PARAM_STR
            ],
            self::$saveMKKurikulum => [
                'id_mk' => Column::BIND_PARAM_STR,
                'id_kurikulum' => Column::BIND_PARAM_STR,
                'sifat' => Column::BIND_PARAM_STR,
                'sks' => Column::BIND_PARAM_INT,
                'semester' => Column::BIND_PARAM_INT
            ],
            self::$deleteMKKurikulum => [
                'id_mk' => Column::BIND_PARAM_STR,
                'id_kurikulum' => Column::BIND_PARAM_STR
            ]
        ];
    }

    private function fetchMataKuliah(string $id) : array
    {
        $listMataKuliah = array();
        $statement = $this->statements[self::$fetchMataKuliah];
        $type = $this->types[self::$fetchMataKuliah];
        $params = [
            'id_kurikulum' => $id
        ];

        $result = $this->db->executePrepared($statement, $params, $type);
        $listResultAssoc = $result->fetchAll(PDO::FETCH_ASSOC);

        foreach ($listResultAssoc as $resultAssoc) {
            $mataKuliah = $this->arrayToEntityMataKuliah($resultAssoc);
            $listMataKuliah[] = $mataKuliah;
        }

        return $listMataKuliah;
    }

    private function fetchMataKuliahById(KurikulumId $kurikulumId, MataKuliahId $mataKuliahId) : ?MataKuliah
    {
        $statement = $this->statements[self::$fetchMataKuliahById];
        $type = $this->types[self::$fetchMataKuliahById];
        $params = [
            'id_kurikulum' => $kurikulumId->id(),
            'id_mk' => $mataKuliahId->id()
        ];
        $result = $this->db->executePrepared($statement, $params, $type);
        
        if ($result->rowCount() == 0) {
            return null;
        }
        $mataKuliah = $this->arrayToEntityMataKuliah($result->fetch(PDO::FETCH_ASSOC));
        return $mataKuliah;
    }
    
    private function arrayToEntityMataKuliah(array $data) : MataKuliah
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
            $data['mata_kuliah_deskripsi'],
            $data['mk_kurikulum_sks'],
            new SifatMataKuliah($data['mk_kurikulum_sifat']),
            $data['mk_kurikulum_semester']
        );

        return $mataKuliah;
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
                    ->listMataKuliah($this->fetchMataKuliah($data['kurikulum_id']))
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

    private function saveMataKuliah(MataKuliah $mataKuliah, KurikulumId $kurikulumId) : void
    {
        $exist = $this->fetchMataKuliahById($kurikulumId, $mataKuliah->getId());
        if (!$exist) {
            $statement = $this->statements[self::$insertMK];
            $type = $this->types[self::$insertMK];
            $params = [
                'id' => $mataKuliah->getId()->id(),
                'id_rmk' => $mataKuliah->getRmk()->id()->id(),
                'kode_matkul' => $mataKuliah->getKode(),
                'nama' => $mataKuliah->getNama()->indonesia(),
                'nama_inggris' => $mataKuliah->getNama()->inggris(),
                'deskripsi' => $mataKuliah->getDeskripsi()
            ];
            $this->db->executePrepared($statement, $params, $type);
        }
        $this->updateMataKuliah($mataKuliah, $kurikulumId);
    }

    private function updateMataKuliah(MataKuliah $mataKuliah, KurikulumId $kurikulumId) : void
    {
        if ($mataKuliah->getStatus() == MataKuliah::$baru) {
            $statement = $this->statements[self::$addMKKurikulum];
        } else {
            $statement = $this->statements[self::$updateMKKurikulum];
        }
        $type = $this->types[self::$saveMKKurikulum];
        $params = [
            'id_mk' => $mataKuliah->getRmk()->id()->id(),
            'id_kurikulum' => $kurikulumId->id(),
            'sifat' => $mataKuliah->getSifat(),
            'sks' => $mataKuliah->getSks(),
            'semester' => $mataKuliah->getSemester()
        ];
        $this->db->executePrepared($statement, $params, $type);
    }

    private function deleteMataKuliah(MataKuliah $mataKuliah, KurikulumId $kurikulumId) : void
    {
        $statement = $this->statements[self::$deleteMKKurikulum];
        $type = $this->types[self::$deleteMKKurikulum];
        $params = [
            'id_mk' => $mataKuliah->getId()->id(),
            'id_kurikulum' => $kurikulumId->id()
        ];
        $this->db->executePrepared($statement, $params, $type);
    }

    public function save(Kurikulum $kurikulum): void
    {
        try {
            $this->db->begin();

            $existing = $this->byId($kurikulum->getId());
            if (empty($existing)) {
                $statement = $this->statements[self::$insert];
            } else {
                $statement = $this->statements[self::$update];
            }
            $type = $this->types[self::$save];
            $params = [
                'id' => $kurikulum->getId()->id(),
                'kode_prodi' => $kurikulum->getProdi()->kode(),
                'aktif' => $kurikulum->getAktif(),
                'nama_indonesia' => $kurikulum->getNama()->indonesia(),
                'nama_inggris' => $kurikulum->getNama()->inggris(),
                'sks_lulus' => $kurikulum->getSksLulus(),
                'sks_wajib' => $kurikulum->getSksWajib(),
                'sks_pilihan' => $kurikulum->getSksPilihan(),
                'semester_normal'=> $kurikulum->getSemesterNormal(),
                'tahun_mulai' => $kurikulum->getPeriode()->mulai()->tahun(),
                'tahun_selesai' => $kurikulum->getPeriode()->selesai()->tahun(),
                'semester_mulai' => $kurikulum->getSemesterMulai()->semester()
            ];
            $this->db->executePrepared($statement, $params, $type);

            foreach ($kurikulum->getListMataKuliah() as $mataKuliah) {
                switch ($mataKuliah->getStatus()) {
                    case MataKuliah::$baru:
                        $this->saveMataKuliah($mataKuliah, $kurikulum->getId());
                        break;
                    case MataKuliah::$ubah:
                        $this->updateMataKuliah($mataKuliah, $kurikulum->getId());
                        break;
                    case MataKuliah::$hapus:
                        $this->deleteMataKuliah($mataKuliah, $kurikulum->getId());
                        break;
                }
            }

            $this->db->commit();

        } catch (Exception $e) {
            $this->db->rollback();
            throw new Exception('Failed to save kurikulum');
        }
    }

    public function delete(KurikulumId $kurikulumId): void
    {
        $statement = $this->statements[self::$delete];
        $type = $this->types[self::$delete];
        $params = [
            'id' => $kurikulumId->id()
        ];
        $success = $this->db->executePrepared($statement, $params, $type);
        if (!$success) {
            throw new Exception('Failed to delete kurikulum');
        }
    }
}
