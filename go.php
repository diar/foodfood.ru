<?php
if (!empty($_GET['to'])) {
    $go = str_replace('http://', '', $_GET['to']);
    header('Location: http://'.$go, true, 303);
    die();
} else {
    header('Location: /', true, 303);
    die();
}