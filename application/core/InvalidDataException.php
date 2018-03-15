<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 15.03.18
 * Time: 14:19
 */

namespace Core;


/**
 * Class InvalidDataException
 * @package Core
 */
class InvalidDataException extends \Exception
{
    /**
     * @var string
     */
    protected $message = "Invalid data entered!";
}