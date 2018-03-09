<?php
/**
 * Created by PhpStorm.
 * User: littleprince
 * Date: 08.03.18
 * Time: 13:50
 */

namespace Core;

use Models\ModelUser;

interface EmailManagerInterface
{
    /**
     * @param string $username
     * @return bool
     */
    function send(string $username) : bool; 
}