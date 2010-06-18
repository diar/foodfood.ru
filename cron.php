<?php
setlocale (LC_CTYPE, "ru_RU.UTF-8");
header('Content-Type: text/html; charset=utf-8');
chdir('/var/www/foodfood.ru');
$_SERVER['DOCUMENT_ROOT']='/var/www/foodfood.ru';
$_SERVER['REQUEST_URI'] = '/kazan/';
include_once ('engine/core/autoload.php');
// Код, запускаемый каждый день в 12:00
// Обновить количество ресторанов у настроения
MD_Mood::calculateMoodCount();
// Обновить рейтинги у ресторанов
MD_Rating::updateRatings();