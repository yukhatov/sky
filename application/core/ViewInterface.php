<?php
/**
 * Created by PhpStorm.
 * User: littleprince
 * Date: 04.03.18
 * Time: 20:12
 */

namespace Core;

/**
 * Interface ViewInterface
 * @package Core
 */
interface ViewInterface
{
    /**
     * @param string $contentView
     * @param string $templateView
     * @param array|null $data
     * @return string
     */
    function generate($contentView, $templateView, $data = null);
}