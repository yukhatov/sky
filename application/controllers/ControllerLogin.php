<?php
/**
 * Created by PhpStorm.
 * User: littleprince
 * Date: 03.03.18
 * Time: 15:52
 */

namespace Controllers;

use Core\Controller;
use Models\ModelUser;

/**
 * Class ControllerLogin
 * @package Controllers
 */
class ControllerLogin  extends Controller
{
    /**
     * Generates login page
     * 
     * @return string
     */
    function actionIndex()
    {
        return $this->view->generate(
            'loginView.php',
            'templateView.php',
            [
                'error' => $_GET['error'] ?? "",
                'success' => $_GET['success'] ?? ""
            ]
        );
    }
}