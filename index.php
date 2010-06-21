<?php
    setlocale (LC_CTYPE, "ru_RU.UTF-8");
    header('Content-Type: text/html; charset=utf-8');
    if (stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.0') ) {
        header('Location: /ie/index_ru.html', true, 303);
    }

    //define('DEBUG','');
    /* -- Запуск ядра -- */ 
    include_once ('engine/core/engine.class.php');
    Engine::initModule();