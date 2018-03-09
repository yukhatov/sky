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
        $mail->Username   = $config['email']['username'];
        $mail->Password   = $config['email']['password'];
        $mail->SetFrom('n0stradamus1199@gmail.com', 'Manager');
        $mail->Subject    = "Account activation";
        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
        $mail->MsgHTML($this->generateBody($user->getId()));
        $address = $user->getEmail();
        $mail->AddAddress($address, "John Doe");

        return $mail->Send();
    }

    /**
     * @param int $userId
     * @return string
     */
    private function generateBody(int $userId) : string
    {
        $link = 'http://' .
            $_SERVER['SERVER_NAME'] .
            $_SERVER['SCRIPT_NAME'] .
            sprintf("?route=user/activate&id=%d", $userId);

        return "Click here to activate your account: $link";
    }
}