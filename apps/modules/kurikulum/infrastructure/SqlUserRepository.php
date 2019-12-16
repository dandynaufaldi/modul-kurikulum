<?php

namespace Siakad\Kurikulum\Infrastructure;

use PDO;
use Phalcon\Db\Column;
use Siakad\Kurikulum\Domain\Model\User;
use Siakad\Kurikulum\Domain\Model\UserRepository;
use Siakad\Kurikulum\Domain\Model\UserRole;

class SqlUserRepository implements UserRepository
{
    private static $byId = 'byId';
    private static $byIdentifier = 'byIdentifier';
    // private static $byIdentifierAndPassword = 'byIdentifierAndPassword';
    private static $roleGreaterThanEqual = 'roleGreaterThanEqual';

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
            user.id AS user_id,
            user.identifier AS user_identifier,
            user.nama AS user_nama,
            user.level AS user_level
        FROM user';

        $this->statements = [
            self::$byId => $this->db->prepare(
                $queryAll . ' WHERE user.id = :id'
            ),
            self::$byIdentifier => $this->db->prepare(
                $queryAll . ' WHERE user.identifier = :identifier'
            ),
            self::$roleGreaterThanEqual => $this->db->prepare(
                $queryAll . ' WHERE user.level >= :level'
            ),
        ];
    }
    
    private function initTypes()
    {
        $this->types = [
            self::$byId => [
                'id' => Column::BIND_PARAM_INT
            ],
            self::$byIdentifier => [
                'identifier' => Column::BIND_PARAM_STR
            ],
            self::$roleGreaterThanEqual => [
                'level' => Column::BIND_PARAM_INT
            ],
        ];
    }

    private function arrayToEntity(array $data) : User
    {
        return new User(
            $data['user_id'],
            $data['user_identifier'],
            $data['user_nama'],
            new UserRole($data['user_level']),
        );
    }

    public function byId(int $id) : User
    {
        $statement = $this->statements[self::$byId];
        $type = $this->types[self::$byId];
        $params = [
            'id' => $id
        ];
        $result = $this->db->executePrepared($statement, $params, $type);
        if ($result->rowCount() == 0) {
            return null;
        }
        $user = $this->arrayToEntity($result->fetch(PDO::FETCH_ASSOC));
        return $user;
    }

    public function byIdentifier(string $identifier) : User
    {
        $statement = $this->statements[self::$byIdentifier];
        $type = $this->types[self::$byIdentifier];
        $params = [
            'identifier' => $identifier
        ];
        $result = $this->db->executePrepared($statement, $params, $type);
        if ($result->rowCount() == 0) {
            return null;
        }
        $user = $this->arrayToEntity($result->fetch(PDO::FETCH_ASSOC));
        return $user;
    }

    /*
    public function byIdentifierAndPassword(string $identifier, string $password)
    {
        # code...
    }
    */

    public function byRoleGreaterThanEqual(int $level)
    {
        $statement = $this->statements[self::$roleGreaterThanEqual];
        $type = $this->types[self::$roleGreaterThanEqual];
        $params = [
            'level' => $level
        ];

        $listUser = array();

        $result = $this->db->executePrepared($statement, $params, $type);
        if ($result->rowCount() == 0) {
            return null;
        }
        $listResultAssoc = $result->fetchAll(PDO::FETCH_ASSOC);

        foreach ($listResultAssoc as $resultAssoc) {
            $user = $this->arrayToEntity($resultAssoc);
            $listUser[] = $user;
        }
        return $listUser;
    }

}
