<?php

class View
{
    public function render( $template, $data = array() )
    {
        $file = DIR_TEMPLATE . '/' . $template . '.php';

        if( file_exists( $file ) ):
            // Преобразовуем масив данных в переменные
            extract( $data );

            include $file;
        else:
            throw new Exception( 'Error: Could not load template ' . $file . '!' );
        endif;
    }
}