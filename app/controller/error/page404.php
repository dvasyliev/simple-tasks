<?php

class ControllerErrorPage404 extends Controller
{
    public function index()
    {
        $data = array();

        $data[ "title" ] = "Страница не найдена!";

        $this->load->view( "error/page404", $data );
    }
}