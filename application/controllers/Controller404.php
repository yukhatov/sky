<?php

namespace Controllers;

use Core\Controller;

/**
 * Class Controller404
 * @package Controllers
 */
class Controller404 extends Controller
{
	/**
	 * Action index
     */
	function actionIndex()
	{
		$this->view->generate('404View.php', 'templateView.php');
	}
}
