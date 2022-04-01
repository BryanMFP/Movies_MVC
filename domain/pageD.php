<?php

class PagesD
{
    private $actualPage;
    private $totalPage;
    private $numResult;
    private $resultForPage;
    private $index;

    public function __construct()
    {
        $this->actualPage    = 1;
        $this->totalPage     = 0;
        $this->numResult     = 0;
        $this->resultForPage = 3;
        $this->index         = 0;
    }

    public function getActualPage()
    {
        return $this->actualPage;
    }

    public function setActualPage($actualPage)
    {
        $this->actualPage = $actualPage;

        return $this;
    }

    public function getTotalPage()
    {
        return $this->totalPage;
    }

    public function setTotalPage($totalPage)
    {
        $this->totalPage = $totalPage;

        return $this;
    }

    public function getNumResult()
    {
        return $this->numResult;
    }

    public function setNumResult($numResult)
    {
        $this->numResult = $numResult;

        return $this;
    }

    public function getResultForPage()
    {
        return $this->resultForPage;
    }

    public function setResultForPage($resultForPage)
    {
        $this->resultForPage = $resultForPage;

        return $this;
    }

    public function getIndex()
    {
        return $this->index;
    }

    public function setIndex($index)
    {
        $this->index = $index;

        return $this;
    }
}

?>