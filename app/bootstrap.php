<?php

require_once DIR_CORE . '/Model.php';
require_once DIR_CORE . '/View.php';
require_once DIR_CORE . '/Controller.php';

require_once DIR_CORE . '/Router.php';

$router = new Router();
$router->start();