<?php
/**
 * Created by PhpStorm.
 * User: littleprince
 * Date: 03.03.18
 * Time: 15:32
 */

namespace Core;

/**
 * Class SqliteDatabaseConnection
 * @package Core
 */
class SqliteDatabaseConnection implements DatabaseConnectionInterface
{
    /**
     * @var
     */
    private static $_instance;
    /**
     * @var mysqlite
     */
    public $db;

    /**
     * @return Connection
     */
    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    /**
     * Connection constructor.
     */
    private function __construct()
    {
        $this->db = $this->getConnection();
    }

    private function __clone() {}

    private function __wakeup() {}

    /**
     * @return \SQLite3
     * @throws \Exception if connection failed
     */
    public function getConnection()
    {
        $config = parse_ini_file(__DIR__ . '/../../config.ini', true);

        if ( !$db = (new \SQLite3($config['db']['db_name']))) {
            throw new \Exception("DB Connection failed");
        }

        $db->exec('CREATE TABLE IF NOT EXISTS user 
          (id INTEGER PRIMARY KEY AUTOINCREMENT, username STRING, password STRING, email STRING, is_active BOOL)');
        $db->exec('CREATE UNIQUE INDEX IF NOT EXISTS username ON user(username)');
        $db->exec('CREATE UNIQUE INDEX IF NOT EXISTS email ON user(email)');

        return $db;
    }
}