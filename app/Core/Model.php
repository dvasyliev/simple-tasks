<?php

class Model
{
    public function load( $model )
    {
        $file = MODEL . '/' . $model . '.php';

        if( file_exists( $file ) ):
            // Подключаем модель
            include_once $file;
        else:
            throw new Exception( 'Error: Could not load model ' . $file . '!' );
        endif;
    }
}