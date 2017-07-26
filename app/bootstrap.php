<?php

require_once CORE . '/Model.php';
require_once CORE . '/View.php';
require_once CORE . '/Controller.php';

require_once CORE . '/Router.php';

$router = new Router();
$router->start();