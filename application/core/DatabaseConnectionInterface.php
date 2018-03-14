<?php
/**
 * Created by PhpStorm.
 * User: littleprince
 * Date: 04.03.18
 * Time: 20:12
 */

namespace Core;

/**
 * Interface DatabaseConnectionInterface
 * @package Core
 */
interface DatabaseConnectionInterface
{
    /**
     * @return mixed
     */
    function getConnection();
}