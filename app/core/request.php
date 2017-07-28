<?php

class Request {
    public $get = array();
    public $post = array();
    public $cookie = array();
    public $files = array();
    public $server = array();

    public function __constrct()
    {
        $this->get = $this->clean( $_GET );
        $this->post = $this->clean( $_POST );
        $this->request = $this->clean( $_REQUEST );
        $this->cookie = $this->clean( $_COOKIE );
        $this->files = $this->clean( $_FILES );
        $this->server = $this->clean( $_SERVER );
    }

    public function clean( $data )
    {
        if( is_array( $data ) ):
            foreach ($data as $key => $value) {
                unset( $data[ $key ] );

                $data[ $this->clean( $key ) ] = $this->clean( $value );
            }
        else:
            $data = htmlspecialchars( $data,  ENT_COMPAT, 'UTF_8' );
        endif;

        return $data;
    }
}
