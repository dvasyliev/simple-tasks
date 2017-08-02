<?php
/*
 * Configurations for project
 */
// Defining paths
define( 'DIR_ROOT',         __DIR__ );
define( 'DIR_CORE',         DIR_ROOT . '/app/core' );
define( 'DIR_MODEL',        DIR_ROOT . '/app/model' );
define( 'DIR_CONTROLLER',   DIR_ROOT . '/app/controller' );
define( 'DIR_VIEW',         DIR_ROOT . '/app/view' );
define( 'DIR_TEMPLATE',     DIR_VIEW . '/template' );
define( 'DIR_CONFIG',       DIR_ROOT . '/config' );

define( 'DIR_IMAGE_NAME',   'image' );
define( 'DIR_IMAGE',        DIR_ROOT . '/' . DIR_IMAGE_NAME );

define( 'DOMAIN' ,          'http://simple-tasks/');

// Database configuration
define( 'DB_DRIVER',        'mpdo' );
define( 'DB_HOST',          'localhost' );
define( 'DB_USER',          'root' );
define( 'DB_PASSWORD',      '' );
define( 'DB_DATABASE',      'simple_tasks' );
define( 'DB_PORT',          '3306' );