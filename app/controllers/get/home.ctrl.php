<?php

class Home extends controller
{

    public function __construct()
    {
        $this->model();
    }

    public function index()
    {

        $this->view("pages/home");

       

    }

    
}