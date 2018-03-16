<?php

namespace Models;

use Core\Model;

/**
 * Class ModelTask
 * @package Models
 */
class ModelUser extends Model
{
    /**
     * @var
     */
    protected $id;
    /**
     * @var
     */
    protected $username;

    /**
     * @var
     */
    protected $password;
    /**
     * @var
     */
    protected $email;
    /**
     * @var
     */
    protected $is_active;

    /**
     * @var
     */
    protected $activation_token;

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getActivationToken()
    {
        return $this->activation_token;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     * @throws InvalidDataException if model not valid
     */
    public function create() : bool
    {
        $stmt = $this->db->prepare('INSERT INTO user(username, password, email, activation_token, is_active) VALUES (:username, :password, :email, :activation_token, :is_active)');
        $this->generateActivationToken();

        $stmt->bindValue(':username', $this->username, SQLITE3_TEXT);
        $stmt->bindValue(':password', password_hash($this->password, PASSWORD_DEFAULT), SQLITE3_TEXT);
        $stmt->bindValue(':email', $this->email, SQLITE3_TEXT);
        $stmt->bindValue(':activation_token', $this->activation_token, SQLITE3_TEXT);
        $stmt->bindValue(':is_active', 0, SQLITE3_INTEGER);
        
        if (!$this->isValid()) {
            throw new \Exception("Invalid data entered!");
        }

        return !empty($stmt->execute()) ? true : false;
    }

    /**
     * @return bool
     * @throws InvalidDataException if model not valid
     */
    public function edit() : bool
    {
        $stmt = $this->db->prepare('UPDATE user SET email=:email WHERE id=:id');

        $stmt->bindValue(':email', $this->email, SQLITE3_TEXT);
        $stmt->bindValue(':id', $this->id, SQLITE3_TEXT);

        if (!$this->isValid()) {
            throw new \Exception("Invalid data entered!");
        }

        return !empty($stmt->execute()) ? true : false;
    }

    /**
     * @param string $username
     * @param string $password
     * @return Model
     */
    public function findByUsernameAndPassword(string $username, string $password) : Model
    {
        $stmt = $this->db->prepare('SELECT * FROM user WHERE username=:username LIMIT 1');

        $stmt->bindValue(':username', $username, SQLITE3_TEXT);

        $result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

        if ($result) {
            if (!password_verify($password, $result['password'])) {
                return $this;
            }

            $this->mapResult($result);
        }
        
        return $this;
    }

    /**
     * @param int $id
     * @return Model
     */
    public function findById(int $id) : Model
    {
        $stmt = $this->db->prepare('SELECT * FROM user WHERE id=:id LIMIT 1');

        $stmt->bindValue(':id', $id, SQLITE3_TEXT);

        $result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
        
        if ($result) {
            $this->mapResult($result);
        }

        return $this;
    }

    /**
     * @param string $token
     * @return Model
     */
    public function findByActivationToken(string $token) : Model
    {
        $stmt = $this->db->prepare('SELECT * FROM user WHERE activation_token=:activation_token LIMIT 1');

        $stmt->bindValue(':activation_token', $token, SQLITE3_TEXT);

        $result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

        if ($result) {
            $this->mapResult($result);
        }

        return $this;
    }

    /**
     * @param string $username
     * @return Model
     */
    public function findByUsername(string $username) : Model
    {
        $stmt = $this->db->prepare('SELECT * FROM user WHERE username=:username LIMIT 1');

        $stmt->bindValue(':username', $username, SQLITE3_TEXT);

        $result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

        if ($result) {
            $this->mapResult($result);
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function activate()
    {
        $sql = sprintf(
            "UPDATE user SET is_active='1' WHERE id='%d'",
            $this->id
        );

        $result = $this->db->query($sql);
        $this->db->close();

        if ($result) {
            return true;
        }

        return false;
    }

    /**
     * @param $username
     * @param $email
     * @param $pass
     * @param $confirmPass
     * @return bool
     */
    public function load($username, $email, $pass, $confirmPass) : bool
    {
        $username = $this->validator->prepareValue($username);
        $email = $this->validator->prepareValue($email);
        $pass = $this->validator->prepareValue($pass);
        
        if (
            $username != "" and
            $email != "" and
            $pass != "" and
            $pass == $confirmPass
        ) {
            $this->username = $username;
            $this->email = $email;
            $this->password = $pass;
            $this->is_active = 0;

            return true;
        }

        return false;
    }

    /**
     * @param array $result
     */
    protected function mapResult(array $result)
    {
        $this->id = $result['id'] ?? "";
        $this->username = $result['username'] ?? "";
        $this->password = $result['password'] ?? "";
        $this->email = $result['email'] ?? "";
        $this->activation_token = $result['activation_token'] ?? "";
        $this->is_active = $result['is_active'] ?? 0;
    }

    /**
     * @return bool
     */
    public function isValid() : bool
    {
        return $this->validator->isValid($this);
    }

    private function generateActivationToken()
    {
        $this->activation_token = bin2hex(random_bytes(20));
    }
}
