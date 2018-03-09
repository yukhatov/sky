<?php
/**
 * Created by PhpStorm.
 * User: littleprince
 * Date: 03.03.18
 * Time: 15:52
 */

namespace Controllers;

use Core\Controller;
use Models\ModelTask;
use Models\ModelUser;
use PHPUnit\Framework\Exception;

/**
 * Class ControllerUser
 * @package Controllers
 */
class ControllerUser extends Controller
{
    /**
     * Generates user settings page
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!$this->isLoggedIn()) {
            return header(sprintf("Location: %s", $this->config['route']['login']));
        } else {
            try {
                $user = $this->getUser();
            } catch(Exception $e) {
                return header(sprintf("Location: %s&error=%s", $this->config['route']['login'], $e->getMessage()));
            }
        }

        return $this->view->generate(
            'userView.php',
            'templateView.php',
            [
                'user' => $user,
                'error' => $_GET['error'] ?? "",
                'success' => $_GET['success'] ?? "",
                'is_logged_in' => true
            ]
        );
    }

    /**
     * Activates user
     */
    public function actionActivate()
    {
        if (isset($_GET['id'])) {
            $user = (new ModelUser())->findById($_GET['id']);

            if ($user->getId() != 0 and $user->activate()) {
                return header(sprintf("Location: %s&success=User+activated!", $this->config['route']['login']));
            }
        }

        return header(sprintf("Location: %s&error=User+not+found!", $this->config['route']['login']));
    }

    /**
     * Edits user
     */
    public function actionEdit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = (new ModelUser())->findById($_POST['id'] ?? "");

            if ($user->getId() != 0 and $user->edit($_POST)) {
                return header(sprintf("Location: %s&success=User+edited!", $this->config['route']['user']));

            }

            return header(sprintf("Location: %s&error=User+not+found!", $this->config['route']['user']));
        }
    }

    /**
     * Creates user
     */
    public function actionCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new ModelUser();

            if (
                $user->load(
                    $_POST["username"] ?? "",
                    $_POST["email"] ?? "",
                    $_POST["pass"] ?? "",
                    $_POST["confirm-pass"] ?? ""
                )
            ) {
                if ($user->create()) {
                    $this->emailManager->send($user->getUsername());

                    return header(sprintf(
                        "Location: %s&success=User: %s created. Please check your email for activation.",
                        $this->config['route']['register'],
                        $user->getUsername()));
                }

                return header(sprintf(
                    "Location: %s&error=User: %s already exists!",
                    $this->config['route']['register'],
                    $user->getUsername()));
            }

            return header(sprintf("Location: %s&error=All+fields+required!", $this->config['route']['register']));
        }

        return header(sprintf("Location: %s", $this->config['route']['login']));
    }

    /**
     * Logs user out 
     */
    function actionLogout()
    {
        session_start();
        unset($_SESSION['login_user']);
        session_destroy();

        return header(sprintf("Location: %s", $this->config['route']['login']));
    }

    /**
     * Logs user in
     */
    function actionLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = (new ModelUser())->findByUsernameAndPassword($_POST['username'] ?? "", $_POST['pass'] ?? "");

            if ($user->getId() != 0) {
                if (!$user->getIsActive()) {
                    return header(sprintf(
                        "Location: %s&error=User+not+activated!+Please+Check+email.",
                        $this->config['route']['login']
                    ));
                }

                session_start();

                $_SESSION['login_user'] = $user->getId();

                return header(sprintf("Location: %s", $this->config['route']['user']));
            }

            return header(sprintf("Location: %s&error=Invalid+credentials!", $this->config['route']['login']));
        }

        return header(sprintf("Location: %s", $this->config['route']['login']));
    }
}