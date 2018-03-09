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
 * Class ControllerRegister
 * @package Controllers
 */
class ControllerRegister  extends Controller
{
    /**
     * Generates register page
     * 
     * @return string
     */
    function actionIndex()
    {
        return $this->view->generate(
            'registerView.php',
            'templateView.php',
            [
                'error' => $_GET['error'] ?? "",
                'success' => $_GET['success'] ?? ""
            ]
        );
    }
}