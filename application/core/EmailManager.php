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

/**
 * Class EmailManager
 * @package Core
 */
class EmailManager implements EmailManagerInterface
{
    private $config;
    
    public function __construct()
    {
        $this->config = @parse_ini_file(__DIR__ . '/../../config.ini', true);

        if (!$this->config) {
            throw new \Exception("Config file parsing error!");
        }
    }
    
    /**
     * @param string $username
     * @return bool
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function send(string $username) : bool
    {
        $user = (new ModelUser())->findByUsername($username);
        $config = parse_ini_file(__DIR__ . '/../../config.ini', true);
        $mail = new PHPMailer();
        
        $mail->IsSMTP();
        $mail->SMTPDebug  = 2;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "tls";
        $mail->Host       = "ssl://smtp.gmail.com";
        $mail->Port       = 465;
        $mail->Username   = $this->config['email']['username'];
        $mail->Password   = $this->config['email']['password'];
        $mail->SetFrom('n0stradamus1199@gmail.com', 'Manager');
        $mail->Subject    = "Account activation";
        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
        $mail->MsgHTML($this->generateBody($user->getActivationToken()));
        $address = $user->getEmail();
        $mail->AddAddress($address, "John Doe");

        return $mail->Send();
    }

    /**
     * @param string $token
     * @return string
     */
    private function generateBody(string $token) : string
    {
        $link = 'http://' .
            $_SERVER['SERVER_NAME'] . ':' .
            $_SERVER['SERVER_PORT'] .
            $_SERVER['SCRIPT_NAME'] .
            sprintf("?route=user/activate&token=%s", $token);

        return "Click here to activate your account: $link";
    }
}