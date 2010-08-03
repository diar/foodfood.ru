<?php

/**
 * Настройки для локального сервера.
 * Для использования - переименовать файл в config.local.php
 */

/**
 * Настройка базы данных
 */
$config['db']['params']['host'] = 'localhost';
$config['db']['params']['port'] = '3306';
$config['db']['params']['user'] = 'root';
$config['db']['params']['pass'] = 'mustdie';
$config['db']['params']['type']   = 'mysql';
$config['db']['params']['dbname'] = 'foodfood';
$config['db']['table']['prefix'] = 'blog_';

$config['path']['offset_request_url'] = '1';
$config['db']['tables']['engine'] = 'MyISAM';

return $config;
?>