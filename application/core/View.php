<?php
/**
 * Created by PhpStorm.
 * User: littleprince
 * Date: 03.03.18
 * Time: 15:32
 */

namespace Core;

/**
 * Class View
 * @package Core
 */
class View implements ViewInterface
{
    /**
     * @param string $contentView
     * @param string $templateView
     * @param array|null $data
     */
    public function generate($contentView, $templateView, $data = null)
    {
        include 'application/views/' . $templateView;
    }
}