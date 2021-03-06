<?php
// Подключаем файл конфигурации
require_once 'config.php';

// Подключаем файл стартового загрузчика
require_once 'app/bootstrap.php';

ini_set('display_errors','Off');

// Создаем экземпляр класса регистратора
$registry = new Registry();

// Создаем экземпляр класса загрузчика и регистрируем его
$loader = new Loader( $registry );
$registry->set( 'load', $loader );

// Создаем экземпляр класса базы данных и регистрируем его
$db = new DB( DB_DRIVER, DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE, DB_PORT );
$registry->set( 'db', $db );

// Создаем екземпляра класса для адресов страниц и регистрируем его
$url = new Url( DOMAIN );
$registry->set( 'url', $url );

// Создаем екземпляра класса для разных видов запросов и регистрируем его
$request = new Request();
$registry->set( 'request', $request );

// Создаем екземпляра класса для разных видов ответов и регистрируем его
$response = new Response();
$registry->set( 'response', $response );

// Создаем екземпляра класса для сессий пользователей и регистрируем его
$session = new Session();
$registry->set( 'session', $session );

// Создаем екземпляра класса для сессий пользователей и регистрируем его
$user = new User( $registry );
$registry->set( 'user', $user );

// Создаем екземпляр класса маршрутизатора и запускаем его
$router = new Router();
$router->start( $registry );