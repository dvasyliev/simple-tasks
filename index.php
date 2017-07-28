<?php

ini_set( 'display_errors', 1 );

// Подключаем файл конфигурации
require_once 'config.php';

// Подключаем файл стартового загрузчика
require_once 'app/bootstrap.php';

// Создаем экземпляр класса регистратора
$registry = new Registry();

// Создаем экземпляр класса загрузчика и регистрируем его
$loader = new Loader( $registry );
$registry->set( 'load', $loader );

// Создаем экземпляр класса базы данных и регистрируем его
$db = new DB( DB_DRIVER, DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE, DB_PORT );
$registry->set( 'db', $db );

// Создаем екземпляра класса для разных видов запросов и регистрируем его
$request = new Request();
$registry->set( 'request', $request );

// Создаем екземпляр класса маршрутизатора и запускаем его
$router = new Router();
$router->start( $registry );
