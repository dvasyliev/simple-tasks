<?php

class ControllerAccountAccount extends Controller
{
    private $error = array();

    public function index()
    {
        $data = array();

        $data[ "is_logged" ] = $this->user->isLogged();
        $data[ "is_admin" ] = $this->user->isAdmin();

        $this->load->view( "account/admin-form", $data );
    }

    public function login()
    {
        if( $this->request->server[ "REQUEST_METHOD" ] === "POST" && $this->validate() ):
            if( $this->user->login( $this->request->post[ "login" ], $this->request->post[ "password" ] ) ):
                $this->response->redirect( DOMAIN );
            else:
                $this->error[ "data" ] = "Неверный логин или пароль";
            endif;
        endif;
    }

    public function logout()
    {
        $this->user->logout();
        $this->session->destroy();
        $this->response->redirect( DOMAIN );
    }

    public function validate()
    {
        $login = $this->request->post[ "login" ];
        $password = $this->request->post[ "password" ];

        if( strlen( trim( $login ) ) < 3 || strlen( trim( $login ) ) > 32 ):
            $this->error[ "login" ] = "Логин должен быть от 3 до 32 символов";
        endif;

        if( strlen( trim( $password ) ) < 3 || strlen( trim( $password ) ) > 32 ):
            $this->error[ "password" ] = "Пароль должен быть от 3 до 32 символов";
        endif;

        return !$this->error;
    }
}