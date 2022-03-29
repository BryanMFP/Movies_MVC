<?php

require_once 'models/moviemodel.php';

class Movie extends SessionController
{
    public function __construct()
    {
        parent::__construct();
        $this->user = $this->getUserSessionData();
        error_log('movie -> ' . $this->user->getId());
        $this->movieModel = new MovieModel();
        $this->numResult = $this->movieModel->getCountNumResulViewByUser($this->user->getId())->getNumResult();
        $this->calculatePage();
    }

    public function render()
    {
        error_log('entra al render movie');
        $showMovie = $this->movieModel->getMovieLimitByUser($this->user);
        $this->view->render('movie/index', 
        [
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
        $movie->setTotalPage(number_format(($numResult / $movie->getResultForPage()), 0));
        
        if(isset($_GET['page']))
        {
            $movie->setActualPage($_GET['page']);
            $movie->setIndex(($movie->getActualPage() - 1) * $movie->getResultForPage());
            error_log('Actual Page nuevo ' . $movie->getActualPage());
        }
    }
}

?>