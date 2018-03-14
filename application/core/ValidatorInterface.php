<?php
/**
 * Created by PhpStorm.
 * User: littleprince
 * Date: 04.03.18
 * Time: 20:12
 */

namespace Core;

interface ValidatorInterface
{
    function isValid(Model $model) : bool;
}