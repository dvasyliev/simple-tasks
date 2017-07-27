<?php

final class Registry
{
    private $data = array();

    public function get( $key )
    {
        return isset( $this->data[ $key ] ) ? $this->data[ $key ] : null;
    }

    public function set( $key, $value )
    {
        if( !isset( $this->data[ $key ] ) ):
            $this->data[ $key ] = $value;
        else:
            trigger_error( 'Error: Variable ' . $key . ' already defined!' );
        endif;
    }

    public function has( $key )
    {
        return isset( $this->data[ $key ] );
    }
}