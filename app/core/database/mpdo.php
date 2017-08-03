<?php

final class mPDO
{
    private $pdo = null;
    private $statement = null;

    public function __construct( $host, $user, $password, $database, $port )
    {
        try {
            // Подключение к базе данных с помощью драйвера PDO и установление постоянного соединения
            $this->pdo = new \PDO(
                'mysql:host=' . $host . ';port = ' . $port . ';dbname=' . $database, $user, $password, array(
                    \PDO::ATTR_PERSISTENT => true
                )
            );
        } catch ( \PDOException $exception ) {
            throw new \Exception( 'Unknown database ' . $database . '!' );
            exit();
        }

        // Установка кодировки UTF-8
//        $this->pdo-exec( 'SET NAMES \'utf8\'' );
//        $this->pdo-exec( 'SET CHARACTER SET utf8' );
//        $this->pdo-exec( 'SET CHARACTER_SET_CONNECTION=uft8' );
//        $this->pdo-exec( 'SET SQL_MODE = \'\'' );
    }

    public function prepare( $sql )
    {
        $this->statement = $this->pdo->prepare( "SET SESSION wait_timeout = 1" );
        $this->statement->execute();
        // Подготовка запроса к выполнению и возвращение объекта,
        // который содержит подготовленный запрос к базе данных
        $this->statement = $this->pdo->prepare( $sql );
    }

    public function execute()
    {
        try {
            // Выполнение запроса, если он подготовлен
            if( $this->statement && $this->statement->execute() ):
                $data = array();

                // Получение и сохранение массива в переменную $data
                while( $row = $this->statement->fetch( \PDO::FETCH_ASSOC ) ):
                    $data[] = $row;
                endwhile;

                $result = new \stdClass();
                $result->row = isset( $data[0] ) ? $data[0] : array();
                $result->rows = $data;
                $result->num_rows = $this->statement->rowCount();
            endif;
        } catch ( \PDOException $exception ) {
            throw new \Exception( 'Error: ' . $exception->getMessage() . ' Error code: ' . $exception->getCode() );
        }
    }

    public function query( $sql, $params = array() )
    {
        $this->statement = $this->pdo->prepare( $sql );
        $result = false;

        try {
            // Выполнение запроса, если он подготовлен
            if( $this->statement && $this->statement->execute( $params ) ):
                $data = array();

                // Получение и сохранение массива в переменную $data
                while( $row = $this->statement->fetch( \PDO::FETCH_ASSOC ) ):
                    $data[] = $row;
                endwhile;

                $result = new \stdClass();
                $result->row = isset( $data[0] ) ? $data[0] : array();
                $result->rows = $data;
                $result->num_rows = $this->statement->rowCount();
            endif;
        } catch ( \PDOException $exception ) {
            throw new \Exception( 'Error: ' . $exception->getMessage() . ' Error code: ' . $exception->getCode() . '<br/> ' . $sql);
        }

        if ($result) {
            return $result;
        } else {
            $result = new \stdClass();
            $result->row = array();
            $result->rows = array();
            $result->num_rows = 0;

            return $result;
        }
    }

    public function escape( $value )
    {
        // Екранируем символы, из-за которых могут возникнуть ошибки в запросе
        return str_replace(
            array( "\\", "\0", "\n", "\r", "\x1a", "'", '"' ),
            array( "\\\\", "\\0", "\\n", "\\r", "\Z", "\'", '\"' ),
            $value
        );
    }
}