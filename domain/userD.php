<?php

class UserD extends Model 
{
    private $id;
    private $username;
    private $secretpassword;
    private $completename;
    private $idrole;
    private $token;
    private $fechaRegistro;
    private $status;

    public function __construct() 
    {
        parent::__construct();
        $this->id             = 0;
        $this->username       = '';
        $this->secretpassword = '';
        $this->completename   = '';
        $this->idrole         = '';
        $this->token          = '';
        $this->status         = '';
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(Int $id)
    {
        $this->id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername(String $username)
    {
        $this->username = $username;
    }

    public function getSecretPassword()
    {
        return $this->secretpassword;
    }

    public function setSecretPassword(String $password, bool $hash = false)
    {
        if($hash)
        {
            $this->secretpassword = $this->getHashedPassword($password);
        }
        else
        {
            $this->secretpassword = $password;
        }
    }

    public function getCompleteName()
    {
        return $this->completename;
    }

    public function setCompleteName(String $completename)
    {
        $this->completename = $completename;
    }

    public function getIdRole()
    {
        return $this->idrole;
    }

    public function setIdRole(Int $idrole)
    {
        $this->idrole = $idrole;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken(String $token, bool $tokenNew =  false)
    {
        if ($tokenNew)
        {
            $this->token = $this->generator_token();
        }
        else
        {
            $this->token = $token;
        }
    }

    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus(String $status)
    {
        $this->status = $status;
    }

    private function getHashedPassword(String $password)
    {
        return password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);
    }

    private function generator_token()
    {
        return md5(bin2hex(random_bytes((32 - (32 % 2)) / 2)));
    }

}

?>