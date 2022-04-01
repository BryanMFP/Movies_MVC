<?php

class Model extends PagesD
{
    public function __construct() 
    {
        parent::__construct();
        $this->db = new DB();
    }

    public function querys($query)
    {
        return $this->db->connect()->query($query);
    }

    public function prepares($query)
    {
        return $this->db->connect()->prepare($query);
    }
}


?>