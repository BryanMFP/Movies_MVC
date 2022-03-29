<?php

require_once 'models/moviemodel.php';

class Principal extends SessionController
{
    public function __construct()
    {
        parent::__construct();
        $this->user = $this->getUserSessionData();
        $this->movieModel = new MovieModel();
        $this->numResult = $this->movieModel->getCountNumResult()->getNumResult();
        $this->calculatePage();
    }

    public function render()
    {
        $showMovie = $this->movieModel->getMovieLimit();
        $this->view->render('principal/index', 
        [
            'user' => $this->user,
            'showMovie' => $showMovie,
            'showTotalResult' => $this->numResult,
            'actualPage' => $this->movieModel->getActualPage(),
            'totalPage' => $this->movieModel->getTotalPage()
        ]);
    }

    public function calculatePage()
    {
        error_log('entra al metodo caculatePage');
        $movie = $this->movieModel;
        $numResult = $this->numResult;
        $movie->setTotalPage(($numResult / $movie->getResultForPage()));
        
        if(isset($_GET['page']))
        {
            $movie->setActualPage($_GET['page']);
            $movie->setIndex(($movie->getActualPage() - 1) * $movie->getResultForPage());
            error_log('Actual Page nuevo ' . $movie->getActualPage());
        }
    }

    public function seemovie($name = [])
    {
        error_log($name[0]);

        if (empty($name)) 
        {
            $this->redirect('principal',
            [
                'error' => Errors::ERROR_ID_EMPTY
            ]);
        }
        else
        {
            $id_user = $this->user;
            $movie = $this->movieModel->get($name[0]);
            $movie->saveView($id_user);
            $totalViews = $movie->getTotalViews();
            $totalViewsByUser = $movie->getTotalViewsByUser($id_user);
            if (empty($movie))
            {
                $this->redirect('principal',
                [
                    'error' => Errors::ERROR_ID_EMPTY
                ]);
            }
            else
            {
                $this->view->render('movie/vwmovie', 
                [
                    'id'               => $movie->getId(),
                    'name'             => $movie->getName(),
                    'image'            => $movie->getImage(),
                    'totalViews'       => $totalViews,
                    'totalViewsByUser' => $totalViewsByUser
                ]);            
            }
        }
        
    }
}

?>