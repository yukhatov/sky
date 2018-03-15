<?php
/**
 * Created by PhpStorm.
 * User: littleprince
 * Date: 08.03.18
 * Time: 13:51
 */

namespace Core;

use Models\ModelUser;
use PHPMailer\PHPMailer\PHPMailer;

class UserValidator implements ValidatorInterface
{
    public function isValid(Model $user) : bool
    {
        return filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL);
    }
    
    public function prepareValue($value) : string
    {
        $value = strip_tags($value);
        $value = htmlentities($value, ENT_QUOTES, "UTF-8");
        $value = htmlspecialchars($value, ENT_QUOTES);
        
        return $value;
    }
}