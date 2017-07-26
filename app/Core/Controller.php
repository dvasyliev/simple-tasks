<?php

class Controller
{
    public $model;
    public $view;

    public function __construct()
    {
        $this->view = new View();
        $this->model = new Model();
    }

    public function index()
    {
        echo 'Controller loaded!';
    }
}