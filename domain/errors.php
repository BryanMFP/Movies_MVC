<?php

class Errors
{
    const ERROR_USER_UPDATENAME_EMPTY            = "0f0735f8603324a7bca482debdf088fa";
    const ERROR_USER_UPDATENAME                  = "98217b0c263b136bf14925994ca7a0aa";
    const ERROR_USER_UPDATEPASSWORD              = "365009a3644ef5d3cf7a229a09b4d690";
    const ERROR_USER_UPDATEPASSWORD_EMPTY        = "0f0735f8603324a7bca482debdf088fa";
    const ERROR_USER_UPDATEPASSWORD_ISNOTTHESAME = "27731b37e286a3c6429a1b8e44ef3ff6";
    const ERROR_LOGIN_AUTHENTICATE               = "11c37cfab311fbe28652f4947a9523c4";
    const ERROR_LOGIN_AUTHENTICATE_EMPTY         = "2194ac064912be67fc164539dc435a42";
    const ERROR_LOGIN_AUTHENTICATE_DATA          = "bcbe63ed8464684af6945ad8a89f76f8";
    const ERROR_SIGNUP_NEWUSER                   = "1fdce6bbf47d6b26a9cd809ea1910222";
    const ERROR_SIGNUP_NEWUSER_EMPTY             = "a5bcd7089d83f45e17e989fbc86003ed";
    const ERROR_SIGNUP_NEWUSER_EXISTS            = "a74accfd26e06d012266810952678cf3";
    const ERROR_PAGE_NOT_EXISTS                  = "26d75273773400c28e3f7f7681d8af0c";
    const ERROR_ID_EMPTY                         = "67aa271bb9c7a94628d963a1f1b3b182";
    const ERROR_TITLE_AVAILABLE                  = "f27010020db55c3f44cdd55723129875";


    private $errorsList = [];

    public function __construct()
    {
        $this->errorsList = 
        [
            Errors::ERROR_USER_UPDATENAME_EMPTY            => 'El nombre no puede estar vacio o ser negativo',
            Errors::ERROR_USER_UPDATENAME                  => 'No se puede actualizar el nombre',
            Errors::ERROR_USER_UPDATEPASSWORD              => 'No se puede actualizar la contraseña',
            Errors::ERROR_USER_UPDATEPASSWORD_EMPTY        => 'El nombre no puede estar vacio o ser negativo',
            Errors::ERROR_USER_UPDATEPASSWORD_ISNOTTHESAME => 'Los passwords no son los mismos',
            Errors::ERROR_LOGIN_AUTHENTICATE               => 'Hubo un problema al autenticarse',
            Errors::ERROR_LOGIN_AUTHENTICATE_EMPTY         => 'Los parámetros para autenticar no pueden estar vacíos',
            Errors::ERROR_LOGIN_AUTHENTICATE_DATA          => 'Nombre de usuario y/o password incorrectos',
            Errors::ERROR_SIGNUP_NEWUSER                   => 'Hubo un error al intentar registrarte. Intenta de nuevo',
            Errors::ERROR_SIGNUP_NEWUSER_EMPTY             => 'Los campos no pueden estar vacíos',
            Errors::ERROR_SIGNUP_NEWUSER_EXISTS            => 'El nombre de usuario ya existe, selecciona otro',
            Errors::ERROR_PAGE_NOT_EXISTS                  => 'La ubicación que buscas no existe :(',
            Errors::ERROR_ID_EMPTY                         => 'El id que buscas no se encuentra',
            Errors::ERROR_TITLE_AVAILABLE                  => 'El titulo que buscas no se encuentra disponible'
        ];
    }

    public function get($hash)
    {
        return $this->errorsList[$hash];
    }

    public function existsKey($key)
    {
        if(array_key_exists($key, $this->errorsList))
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