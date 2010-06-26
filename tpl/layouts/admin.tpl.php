<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
    <head>
        <title><?=self::get('pageTitle');?> | Панель администратора</title>
        <link rel="stylesheet" type="text/css" href="/public/css/jquery-ui/flick/jquery-ui.css" />
        <link rel="stylesheet" type="text/css" href="/admin/adminStyle.css" />
        <link rel="stylesheet" type="text/css" href="/public/js/libs/grid/jquery.jqGrid.css" />
        <script type="text/javascript" src="http://www.google.com/jsapi"></script>
        <script type="text/javascript">
            google.load("jquery", "1.4.2");
            google.load("jqueryui", "1.8");
            google.load("swfobject", "2.2");
        </script>
        <script type="text/javascript" src="/admin/js/jquery.form.js"></script>
        <script type="text/javascript" src="/admin/js/lib.js"></script>
        <script type="text/javascript" src="/admin/js/onload.js"></script>
        <script type="text/javascript" src="/admin/js/ajaxForm.js"></script>
        <script type="text/javascript" src="/engine/libs/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="/engine/libs/filemanager/ajex.js"></script>
        <script type="text/javascript" src="/public/js/libs/grid/jquery.jqGrid.ru.js"></script>
        <script type="text/javascript" src="/public/js/libs/grid/jquery.jqGrid.min.js"></script>
    </head>
    <body>
        <?php $admin = self::get('admin');?>
        <div id="logout"><?=$admin['login']?>
            <a href="admin.php?logout">Выйти</a>
        </div>
        <table id="main_table">
            <tr	id="header">
                <td class="left"><img src="images/logo.png" /></td>
                <td class="right" colspan="2">
                    <div id="menu">
                        <ul>
                            <? $menu = self::get('menu');
                            $z = 0;
                            foreach ($menu as $item) : $z++;?>

                            <li><a href="#menu-<?=$z?>"><?=$item['title']?></a></li>

                            <?endforeach;?>
                        </ul>
                        <? $z = 0;
                        foreach ($menu as $item) : $z++; ?>

                        <div id="menu-<?=$z?>" class="submenu">
                            <ul>
                                    <? foreach ($item['childs'] as $child) :?>
                                <li class="item" rel="<?= $child['page'] ?>">
                                    <a class="ui_button" href="<?=AdminModule::getLink($child['page'], $child['action'])?>"><?=$child['title']?></a>
                                </li>
                                    <? endforeach;?>
                            </ul>
                        </div>

                        <? endforeach;?>
                    </div>
                </td>
            </tr>
            <tr id="content">
                <td class="left">
                    <div id="rest_change<?php if($admin['access'] != 'superadmin') echo'_non_modify';?>" class="rest_change">
                        <?=!$admin['restaurant']['rest_title'] ? "Выберите ресторан" : $admin['restaurant']['rest_title'] ;?>
                    </div>
                    <?php if ($admin['access'] == 'superadmin') : ?>
                    <ul id="pageMenu">
                        <li><a href="<?=AdminModule::getLink('restaurants','showList') ?>">Список ресторанов</a> </li>
                        <li><a href="<?=AdminModule::getLink('restaurants','add') ?>">Добавить ресторан</a> </li>
                        <li style="width:100%; border-bottom: 1px solid #ccc; margin:4px 0;"></li>
                            <?php if ($pageMenu = self::get('pageMenu')) : ?>
                                <? foreach ($pageMenu as $action => $title) : ?>
                        <li><a href="<?=AdminModule::getLink(PAGE,$action) ?>"><?=$title?></a> </li>
                                <? endforeach;?>
                            <?endif;?>
                    </ul>
                    <?endif;?>
                </td>
                <td class="right">
                    <div id="divToUpdate"></div>
                    <?=self::get('html');?>
                </td>
            </tr>
            <tr id="footer">
                <td ></td>
                <td ></td>
            </tr>
        </table>
        <div id="rest_list">
            <ul>
                <?php
                if ($admin['access'] == 'superadmin') {
                    $list = self::get('rest_list');
                    $z = 1;
                    $s = '';
                    foreach ($list as $rest) {

                        $utf8string = mb_substr($rest['rest_title'],0,1,'UTF-8');
                        //Если новая буква то выводим эту букву
                        if ($s != $utf8string) {
                            echo "<li class='liter'>$utf8string</li>";
                            $z+=1.5;
                        }
                        $link = AdminModule::getLink('system','setRestaurant',$rest['id']);
                        echo "<li><a href='$link'>$rest[rest_title] ($rest[rest_address])</a></li>";
                        $z++;
                        $s = $utf8string;
                        if ($z / 90 > 1) {
                            echo '</ul><ul>';
                            $z = 0;
                        }

                    }
                }
                ?>
            </ul>
        </div>


    </body>
</html>