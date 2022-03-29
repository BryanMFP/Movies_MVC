<?php

require_once 'libs/imodel.php';
require_once 'domain/userD.php';

class UserModel extends UserD implements IModel
{

    //strip_tags()
    public function __construct() 
    {
        parent::__construct();
    }

    public function save()
    {
        try 
        {
            $username        = $this->getUsername();
            $secret_password = $this->getSecretPassword();
            $completeName    = $this->getCompleteName();
            $idRole          = $this->getIdRole();

            $stmt = $this->prepares("INSERT INTO users(username, secret_password, complete_name, id_role) 
                                    VALUES(:username, :secret_password, :complete_name, :id_role)");

            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':secret_password', $secret_password, PDO::PARAM_STR);
            $stmt->bindParam(':complete_name', $completeName, PDO::PARAM_STR);
            $stmt->bindParam(':id_role', $idRole, PDO::PARAM_INT);

            
            if ($stmt->execute())
            {
                return true;
            }
            else
            {
                return false;
            }
        } 
        catch (PDOException $e) 
        {
            error_log('USERMODEL::save -> ' . $e);
            return false;
        }
    }

    public function getAll()
    {
        $items = [];

        try 
        {
            $stmt = $this->querys('SELECT * FROM users');

            while ($p = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $users = new UserModel();
                $item = $users->from($p);

                array_push($items, $item);
            }

            return $items;
        }
        catch (PDOException $e) 
        {
            error_log('USERMODEL::getAll -> ' . $e);
            return false;
        }
    }

    public function get($id)
    {
        try 
        {
            $stmt = $this->prepares('SELECT * FROM users WHERE id_user = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            $users = new UserModel();
            $item = $users->from($user);

            return $item;
            
        } 
        catch (PDOException $e) 
        {
            return [];
            error_log('USERMODEL::get -> ' . $e);
        }
    }

    public function delete($id)
    {
        try 
        {
            $stmt = $this->prepares('DELETE FROM users WHERE id = :id');
            $stmt->bindParam(':id', $id);

            if ($stmt->execute())
            {
                return true;
            }
            else 
            {
                return true;
            }
        } 
        catch (PDOException $e) 
        {
            error_log('USERMODEL::delete -> ' . $e);
            return false;
        }
    }

    public function update()
    {
        try 
        {
            $stmt = $this->prepares('UPDATE users SET username = :username, complete_name = :complete_name WHERE id = :id');

            $stmt->bindParam(':username', $this->getUsername(), PDO::PARAM_STR);
            $stmt->bindParam(':complete_name', $this->getCompleteName(), PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->getId(), PDO::PARAM_STR);

            if ($stmt->execute()) 
            {
                return true;
            }
            else
            {
                return true;
            }
        } 
        catch (PDOException $e) 
        {
            error_log('USERMODEL::update -> ' . $e);
            return false;
        }
    }
    
    public function from(Array $array)
    {
        try 
        {
            $this->setId($array['id_user']);
            $this->setUsername($array['username']);
            $this->setSecretPassword($array['secret_password']);
            $this->setCompleteName($array['complete_name']);
            $this->setIdRole($array['id_role']);
            $this->setToken($array['token']);
            $this->setFechaRegistro($array['fecha_registro']);
            $this->setStatus($array['estatus']);

            return $this;
        }
        catch (PDOException $e) 
        {
            error_log('USERMODEL::from -> ' . $e);
            return [];
        }
    }

    public function exists($username)
    {
        try 
        {
            $stmt = $this->prepares('SELECT username FROM users WHERE username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->rowCount() > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        } 
        catch (PDOException $e) 
        {
            error_log('USERMODEL::exists -> ' . $e);
            return false;
        }
    }

    public function login($username, $password)
    {
        try 
        {
            $stmt = $this->prepares('SELECT * FROM users WHERE username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->rowCount() == 1) 
            {
                $item = $stmt->fetch(PDO::FETCH_ASSOC);

                $user = new UserModel();
                $usuario = $this->from($item);

                if (password_verify($password, $usuario->getSecretPassword())) 
                {
                    return $usuario;
                }
                else 
                {
                    return NULL;
                }
            }
            else
            {
                return NULL;
            }
        } 
        catch (PDOException $e) 
        {
            error_log('LoginModel::login->exception ' . $e);
            return NULL;
        }
    }

    public function setRegisterLogin($idUser)
    {
        error_log('idUser' . $idUser);
        $stmt = $this->prepares("INSERT INTO login_register(id_user) VALUES(:id_user)");
        $stmt->bindParam(':id_user', $idUser, PDO::PARAM_INT);

       
        if ($stmt->execute())
        {
            error_log('entra al verdadero');
            return true;
        }
        else
        {
            error_log('entra al falso');
            return false;
        }
    }

    public function comparePasswords($password, $id)
    {
        try 
        {
            $user = $this->get($id);
            return password_verify($password, $user->getSecretPassword());
        } 
        catch (PDOException $e) 
        {
            error_log('USERMODEL::comparePasswords -> ' . $e);
            return false;
        }
    }

    public function updatePassword($new, $iduser)
    {
        try
        {
            $this->setSecretPassword(strip_tags($new), true);
            $stmt = $this->prepares('UPDATE users SET secret_password = :val WHERE id = :id');
            $stmt->execute
            ([
                'val' => $this->getSecretPassword(), 
                'id' => $iduser
            ]);

            if($stmt->rowCount() > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        catch(PDOException $e)
        {
            return NULL;
            error_log('USERMODEL::updatePassword -> ' . $e);
        }
    }

    public function updateToken($new, $iduser)
    {
        try
        {
            $this->setToken('', true);
            $stmt = $this->prepares('UPDATE users SET secret_password = :val WHERE id = :id');
            $stmt->execute(
            [
                'val' => $this->getSecretPassword(), 
                'id' => $iduser
            ]);

            if($stmt->rowCount() > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        
        }
        catch(PDOException $e)
        {
            return NULL;
            error_log('USERMODEL::updatePassword -> ' . $e);
        }
    }

}

?>