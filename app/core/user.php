<?php

class User
{
    public function __construct( $registry )
    {
        $this->db = $registry->get( 'db' );
        $this->request = $registry->get( 'request' );
        $this->session = $registry->get( 'session' );
    }

    public function login( $login, $password )
    {
        $user_query = $this->db->query(
            "SELECT * 
             FROM user 
             WHERE login = '" . $this->db->escape( $login ) . "' 
                AND password = '" . $this->db->escape( md5( $password ) ) . "'"
        );

        if( $user_query->num_rows ):
            $_SESSION[ "id_user" ] = $user_query->row[ "id_user" ];
            $_SESSION[ "login" ] = $user_query->row[ "login" ];
            $_SESSION[ "password" ] = $user_query->row[ "password" ];

            $user_group_query = $this->db->query(
                "SELECT group_name 
                 FROM user_group 
                 WHERE id_user_group = '" . (int)$user_query->row[ "id_user_group" ] . "'"
            );
            $_SESSION[ "user_group" ] = $user_group_query->row[ "group_name" ];

            return true;
        else:
            return false;
        endif;
    }

    public function logout()
    {
        unset( $_SESSION[ "id_user" ] );
        unset( $_SESSION[ "login" ] );
        unset( $_SESSION[ "password" ] );
        unset( $_SESSION[ "user_group" ] );
    }

    public function isLogged()
    {
        return $_SESSION[ "id_user" ];
    }

    public function isAdmin()
    {
        return $_SESSION[ "user_group" ] === 'administrator';
    }

    public function getLogin()
    {
        return $_SESSION[ "login" ];
    }
}