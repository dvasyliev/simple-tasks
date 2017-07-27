<?php

// Подключаем клас регистратора
require_once DIR_CORE . '/registry.php';

// Подключаем клас маршрутизатора
require_once DIR_CORE . '/router.php';

// Подключаем класс загрузчика
require_once DIR_CORE . '/loader.php';

// Подключаем классы для работы с базой данных
require_once DIR_CORE . '/database/mpdo.php';
require_once DIR_CORE . '/database.php';

// Подключаем класс Контролер, Модель
require_once DIR_CORE . '/controller.php';
require_once DIR_CORE . '/model.php';