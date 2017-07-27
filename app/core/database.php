<?php
class DB
{
    private $db;

    public function __construct( $driver, $host, $user, $password, $database, $port = NULL )
    {
        $class = $driver;

        if( class_exists( $class ) ):
            $this->db = new $class( $host, $user, $password, $database, $port = NULL );
        else:
            exit( 'Error: Could not load database driver ' . $driver );
        endif;
    }

    public function query( $sql )
    {
        return $this->db->query( $sql );
    }
}