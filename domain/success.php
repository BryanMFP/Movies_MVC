<?php

class Success
{
    //ERROR|SUCCESS
    //Controller
    //method
    //operation
    
    const SUCCESS_USER_UPDATE           = "6fb34a5e4118fb823636ca24a1d21669";
    const SUCCESS_USER_UPDATEPASSWORD   = "6fb34a5e4118fb823636ca24a1d21669";
    const SUCCESS_SIGNUP_NEWUSER        = "8281e04ed52ccfc13820d0f6acb0985a";
    
    private $successList = [];

    public function __construct()
    {
        $this->successList = 
        [
            Success::SUCCESS_USER_UPDATE         => "NOMBRE ACTUALIZADO CORRECTAMENTE",
            Success::SUCCESS_USER_UPDATEPASSWORD => "CONTRASEÑA ACTUALIZADA CORRECTAMENTE",
            Success::SUCCESS_SIGNUP_NEWUSER      => "USUARIO REGISTRADO CORRECTAMENTE"
        ];
    }

    function get($hash)
    {
        return $this->successList[$hash];
    }

    function existsKey($key)
    {
        if(array_key_exists($key, $this->successList))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
?>