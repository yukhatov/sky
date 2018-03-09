<?php
/**
 * Created by PhpStorm.
 * User: littleprince
 * Date: 03.03.18
 * Time: 15:30
 */

namespace Core;

/**
 * Class Model
 * @package Core
 */
abstract class Model
{
    /**
     * @var mysqli
     */
    public $db;

    /**
     * Model constructor.
     */
    function __construct()
    {
        $this->db = SqliteDatabaseConnection::getInstance()->db;
    }

    /**
     * @return bool
     */
    abstract public function create();

    /**
     * @param array $data
     * @return bool
     */
    abstract public function edit($data) : bool;

    abstract protected function mapResult(array $result);
}