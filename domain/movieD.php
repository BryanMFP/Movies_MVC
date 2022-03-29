<?php

class MovieD extends Model
{
    private $id;
    private $title;
    private $name;
    private $image;
    private $actualPage;
    private $totalPage;
    private $numResult;
    private $resultForPage;
    private $index;

    public function __construct()
    {
        parent::__construct();
        $this->id            = 0;
        $this->title         = '';
        $this->name          = '';
        $this->image         = '';
        $this->actualPage    = 1;
        $this->totalPage     = 0;
        $this->numResult     = 0;
        $this->resultForPage = 3;
        $this->index         = 0;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getActualPage()
    {
        return $this->actualPage;
    }

    public function setActualPage($actualPage)
    {
        $this->actualPage = $actualPage;
    }

    public function getTotalPage()
    {
        return $this->totalPage;
    }

    public function setTotalPage($totalPage)
    {
        $this->totalPage = $totalPage;
    }

    public function getNumResult()
    {
        return $this->numResult;
    }

    public function setNumResult($numResult)
    {
        $this->numResult = $numResult;
    }

    public function getResultForPage()
    {
        return $this->resultForPage;
    }

    public function setResultForPage($resultForPage)
    {
        $this->resultForPage = $resultForPage;
    }

    public function getIndex()
    {
        return $this->index;
    }

    public function setIndex($index)
    {
        $this->index = $index;
    }
}

?>