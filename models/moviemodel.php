<?php

require_once 'domain/movieD.php';

class MovieModel extends MovieD implements IModel
{
    public function __construct()
    {
        parent::__construct();
    }

    public function save()
    {
        try 
        {
            $name  = $this->getName();
            $image = $this->getImage();

            $stmt = $this->prepares("INSERT INTO movie(name, image) VALUES(:name, :image)");

            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':image', $image, PDO::PARAM_STR);

            
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
            error_log('MOVIEMODEL::save -> ' . $e);
            return false;
        }
    }

    public function getAll()
    {
        $items = [];

        try 
        {
            $stmt = $this->querys('SELECT * FROM movie');

            while ($p = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $movie = new MovieModel();
                $item = $movie->from($p);

                array_push($items, $item);
            }

            return $items;
        }
        catch (PDOException $e) 
        {
            error_log('MOVIEMODEL::getAll -> ' . $e);
            return false;
        }
    }

    public function get($name)
    {
        $movies = [];
        try 
        {
            $stmt = $this->prepares('SELECT * FROM movie WHERE name = :name');
            $stmt->bindParam(':name', $name);
            $stmt->execute();

            $movies = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!empty($movies))
            {
                $movie = new MovieModel();
                $item = $movie->from($movies);

                return $item;
            }
            else
            {
                return [];
            }

        } 
        catch (PDOException $e) 
        {
            return [];
            error_log('MOVIEMODEL::get -> ' . $e);
        }
    }

    public function delete($id)
    {
        try 
        {
            $stmt = $this->prepares('DELETE FROM movie WHERE id_movie = :id');
            $stmt->bindParam(':id', $id);

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
            error_log('MOVIEMODEL::delete -> ' . $e);
            return false;
        }
    }

    public function update()
    {
        try 
        {
            $id    = $this->getId();
            $name  = $this->getName();
            $image = $this->getImage();

            $stmt = $this->prepares('UPDATE movie SET name = :name, image = :image WHERE id_movie = :id');

            $stmt->bindParam(':image', $image, PDO::PARAM_STR);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);

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
            error_log('MOVIEMODEL::update -> ' . $e);
            return false;
        }
    }
    
    public function from(Array $array)
    {
        try 
        {
            $this->setId($array['id_movie']);
            $this->setName($array['name']);
            $this->setImage($array['image']);

            return $this;
        }
        catch (PDOException $e) 
        {
            error_log('MOVIEMODEL::from -> ' . $e);
            return [];
        }
    }

    public function getMovieLimit()
    {
        $items = [];
        try 
        {
            $indice = $this->getIndex();
            $n      = $this->getResultForPage();

            $stmt = $this->prepares('SELECT * FROM movie LIMIT :pos, :n');
            $stmt->bindParam(':pos', $indice, PDO::PARAM_INT);
            $stmt->bindParam(':n', $n, PDO::PARAM_INT);
            $stmt->execute();

            while ($p = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $movie = new MovieModel();
                $item = $movie->from($p);

                array_push($items, $item);
            }

            return $items;
        }
        catch (PDOException $e) 
        {
            error_log('MOVIEMODEL::getMovieLimit -> ' . $e);
            return [];
        }
    }

    public function getMovieLimitByUser($user)
    {
        $items = [];
        try 
        {
            $indice = $this->getIndex();
            $n      = $this->getResultForPage();
            $iduser   = $user->getId();

            $stmt = $this->prepares('SELECT r.id_movie, m.name, m.image FROM movie m
                                    INNER JOIN register_user_movie r
                                    ON m.id_movie = r.id_movie
                                    WHERE id_user = :id_user LIMIT :pos, :n');
            $stmt->bindParam(':pos', $indice, PDO::PARAM_INT);
            $stmt->bindParam(':n', $n, PDO::PARAM_INT);
            $stmt->bindParam(':id_user', $iduser, PDO::PARAM_INT);
            $stmt->execute();

            while ($p = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $movie = new MovieModel();
                $item = $movie->from($p);

                array_push($items, $item);
            }

            return $items;
        }
        catch (PDOException $e) 
        {
            error_log('MOVIEMODEL::getMovieLimit -> ' . $e);
            return [];
        }
    }

    public function getCountNumResult()
    {
        try 
        {
            $stmt = $this->querys('SELECT COUNT(*) AS total FROM movie');
            $stmt->execute();

            $total = $stmt->fetch(PDO::FETCH_OBJ)->total;

            $movie = new MovieModel();
            $movie->setNumResult($total);

            return $movie;
        }
        catch (PDOException $e) 
        {
            error_log('MOVIEMODEL::countPage -> ' . $e);
            return [];
        }
    }

    public function getCountNumResulViewByUser($user)
    {
        try 
        {
            error_log('iduser count -> ' . $user);
            $stmt = $this->prepares('SELECT COUNT(*) AS total FROM register_user_movie WHERE id_user = :id_user');
            $stmt->bindParam(':id_user', $user);
            $stmt->execute();

            $total = $stmt->fetch(PDO::FETCH_OBJ)->total;

            $movie = new MovieModel();
            $movie->setNumResult($total);

            error_log($movie->getNumResult(). '       ' . $user);

            return $movie;
        }
        catch (PDOException $e) 
        {
            error_log('MOVIEMODEL::getCountNumResulViewByUser -> ' . $e);
            return [];
        }
    }

    public function getTotalViews()
    {
        $id_movie = $this->getId();

        $stmt = $this->prepares('SELECT SUM(reg_views) AS views FROM register_user_movie WHERE id_movie = :id_movie');
        $stmt->bindParam(':id_movie', $id_movie);
        $stmt->execute();

        $views = $stmt->fetch(PDO::FETCH_OBJ)->views;

        if ($views > 0)
        {
            error_log($views);
            return $views;
        }
        else
        {
            return 0;
        }
    }

    public function getTotalViewsByUser($idUser)
    {
        $user = $idUser->getId();
        $id_movie = $this->getId();

        $stmt = $this->prepares('SELECT SUM(reg_views) AS views FROM register_user_movie WHERE id_user = :id_user 
                                AND id_movie = :id_movie');
        $stmt->bindParam(':id_user', $user);
        $stmt->bindParam(':id_movie', $id_movie);
        $stmt->execute();

        $views = $stmt->fetch(PDO::FETCH_OBJ)->views;

        if ($views > 0)
        {
            error_log($views);
            return $views;
        }
        else
        {
            return 0;
        }
    }

    public function saveView($iduser)
    {
        error_log('saveView ->' . $this->getName());
        $totalViews = $this->getTotalViewsByUser($iduser);

        if ($totalViews)
        {
            $this->updateViewMovie($iduser, $totalViews);
        }
        else
        {
            $this->saveRegisterView($iduser);
        }
    }

    public function saveRegisterView($user)
    {
        try 
        {
            $iduser = $user->getId();
            $id_movie = $this->getId();

            $stmt = $this->prepares('INSERT INTO register_user_movie(id_user, id_movie, reg_views)VALUES(:id_user, :id_movie, 1)');
            $stmt->bindParam(':id_user', $iduser);
            $stmt->bindParam(':id_movie', $id_movie);

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
            error_log('MOVIEMODEL::updateViewMovie -> ' . $e);
            return [];
        }
    }

    public function updateViewMovie($user, $views)
    {
        try 
        {
            $iduser = $user->getId();
            $id_movie = $this->getId();

            $stmt = $this->prepares('UPDATE register_user_movie SET reg_views = (:view + 1) WHERE id_user = :id_user 
                                    AND id_movie = :id_movie');
            $stmt->bindParam(':view', $views);
            $stmt->bindParam(':id_user', $iduser);
            $stmt->bindParam(':id_movie', $id_movie);

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
            error_log('MOVIEMODEL::updateViewMovie -> ' . $e);
            return [];
        }
    }
}

?>