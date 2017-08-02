<?php

class Session
{
    public function __construct()
    {
        if( !session_id() ):
            session_start();
        endif;
    }

    public function destroy()
    {
        return session_destroy();
    }
}