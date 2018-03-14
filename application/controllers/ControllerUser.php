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
            } catch(\Exception $e) {
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
                return header(sprintf(
                        "Location: %s&success=%s",
                        $this->config['route']['login'],
                        urlencode('User activated!')
                    )
                );
            }
        }

        return header(sprintf(
                "Location: %s&error=%s",
                $this->config['route']['login'],
                urlencode('User not found!')
            )
        );
    }

    /**
     * Edits user
     */
    public function actionEdit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = (new ModelUser())->findById($_POST['id'] ?? "");

            if ($user->getId() == 0) {
                return header(sprintf(
                        "Location: %s&error=%s",
                        $this->config['route']['user'],
                        urlencode('User not found!')
                    )
                );
            }



            /*if ($user->getId() != 0 and $user->edit($_POST)) {
                return header(sprintf(
                        "Location: %s&success=%s",
                        $this->config['route']['user'],
                        urlencode('User edited!')
                    )
                );
            }

            return header(sprintf(
                    "Location: %s&error=%s",
                    $this->config['route']['user'],
                    urlencode('User not found!')
                )
            );*/
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
                !$user->load(
                    $_POST["username"] ?? "",
                    $_POST["email"] ?? "",
                    $_POST["pass"] ?? "",
                    $_POST["confirm-pass"] ?? ""
                )
            ) {
                return header(sprintf(
                        "Location: %s&error=%s",
                        $this->config['route']['register'],
                        urlencode('All fields required!')
                    )
                );
            }

            if (!$user->isValid()) {
                return header(sprintf(
                        "Location: %s&error=%s",
                        $this->config['route']['register'],
                        urlencode('Email is incorrect!')
                    )
                );
            }

            if ($user->create()) {
                $this->emailManager->send($user->getUsername());

                return header(sprintf(
                    "Location: %s&success=%s",
                    $this->config['route']['register'],
                    urlencode('User: ' . $user->getUsername() . ' created. Please check your email for activation.')));
            }

            return header(sprintf(
                    "Location: %s&error=%s",
                    $this->config['route']['register'],
                    urlencode('User: ' . $user->getUsername() . ' already exists!')
                )
            );
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
                            "Location: %s&error=%s",
                            $this->config['route']['login'],
                            urlencode('User not activated! Please Check email.')
                        )
                    );
                }

                session_start();

                $_SESSION['login_user'] = $user->getId();

                return header(sprintf("Location: %s", $this->config['route']['user']));
            }

            return header(sprintf(
                    "Location: %s&error=%s",
                    $this->config['route']['login'],
                    urlencode('Invalid credentials!')
                )
            );
        }

        return header(sprintf("Location: %s", $this->config['route']['login']));
    }
}