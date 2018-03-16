<?php
/**
 * Created by PhpStorm.
 * User: littleprince
 * Date: 03.03.18
 * Time: 15:31
 */

namespace Core;

use Models\ModelUser;
use PHPUnit\Framework\Exception;


/**
 * Class Controller
 * @package Core
 */
class Controller
{
    /**
     * @var ViewInterface
     */
    protected $view;

    /**
     * @var EmailManagerInterface
     */
    protected $emailManager;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var
     */
    protected $user;

    /**
     * Controller constructor.
     * @param ViewInterface $view
     */
    function __construct(ViewInterface $view, EmailManagerInterface $emailManager)
    {
        $this->view = $view;
        $this->emailManager = $emailManager;
        $this->config = @parse_ini_file(__DIR__ . '/../../config.ini', true);

        if (!$this->config) {
            throw new \Exception("Config file parsing error!");
        }
    }

    /**
     * @return bool
     */
    protected function isLoggedIn() : bool
    {
        session_start();

        if (isset($_SESSION['login_user'])) {
            return true;
        }

        return false;
    }

    /**
     * @throws \Exception if user not found
     */
    protected function auth()
    {
        if (!$this->isLoggedIn()) {
            throw new \Exception("User not found!");
        }

        $user = (new ModelUser())->findById($_SESSION['login_user']);

        if ($user->getId() == 0) {
            throw new \Exception("User not found!");
        }

        $this->user = $user;
    }
}