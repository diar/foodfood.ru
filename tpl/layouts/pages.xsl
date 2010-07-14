<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>
    <!-- Импорт меню -->
    <xsl:include href="../blocks/menu.xsl" />
    <xsl:include href="../blocks/dialogs.xsl" />
    <xsl:include href="../blocks/by_mood.xsl" />
    <xsl:include href="../blocks/char_list.xsl" />
    <!-- Макет -->
    <xsl:template match="root">
        <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
            <head>
                <title>
                    <xsl:value-of select="site/title" />
                </title>
                <meta name="keywords" content="{site/keywords}" />
                <meta name="description" content="{site/description}" />
                <link rel="icon" type="image/vnd.microsoft.icon"  href="/public/images/favicon.ico" />
                <link rel="stylesheet" type="text/css" href="/public/js/libs/lightbox/css/jquery.lightbox.css" />
                <link rel="stylesheet" type="text/css" href="/public/css/style.css" />
                <link rel="stylesheet" type="text/css" href="/public/css/pages.css" />
                <xsl:comment><![CDATA[[if IE]>
                    <link href="/public/css/ie.css" rel="stylesheet" type="text/css" />
                <![endif]]]>
                </xsl:comment>
            </head>
            <body>
                <xsl:apply-templates select="header" />
                <div class="clear"></div>
                <xsl:apply-templates select="content" />
                <xsl:call-template name="footer" />
                <xsl:call-template name="auth_dialog" />
                <xsl:call-template name="registration_dialog" />
                <xsl:call-template name="discount_dialog" />
                <xsl:call-template name="message_dialog" />
                <xsl:call-template name="passwd_dialog" />
                <xsl:call-template name="callback_dialog" />
                <script type="text/javascript" src="http://www.google.com/jsapi"></script>
                <script type="text/javascript">
                    <xsl:text>google.load("jquery", "1.4.2");</xsl:text>
                    <xsl:text>google.load("swfobject", "2.2");</xsl:text>
                    <xsl:text>site_city = '</xsl:text>
                    <xsl:value-of select="site/city" />
                    <xsl:text>';</xsl:text>
                    <xsl:text>user_auth = '</xsl:text>
                    <xsl:value-of select="//user/is_auth" />
                    <xsl:text>';</xsl:text>
                </script>
                <script type="text/javascript" src="/public/js/libs/jquery.libs.js"></script>
                <script type="text/javascript" src="/public/js/libs/lightbox/js/jquery.lightbox.pack.js"></script>
                <script type="text/javascript" src="/public/js/system.js"></script>
                <script type="text/javascript" src="/public/js/moods.js"></script>
                <script type="text/javascript" src="/public/js/pages.js"></script>
            </body>
        </html>
    </xsl:template>

    <!-- Заголовок страницы -->
    <xsl:template match="header">
        <div id="header">
            <div id="logo">
                <a href="/"  title="Кафе и рестораны Казани">
                    <img src="/public/images/logo.png" alt="Настроение есть!" />
                </a>
            </div>
            <xsl:apply-templates select="banner" />
            <div class="clear"></div>
        </div>
        <div id="topMenu">
            <xsl:apply-templates select="../menu/item" />
        </div>
        <div class="clear"></div>
        <!-- Панель поиска -->
        <div id="search_menu">
            <a href="#" class="no_text_select" id="show_moods">Настроение</a>
            <a href="#" class="no_text_select" id="show_search">Поиск</a>
            <a href="#" class="no_text_select" id="show_all">Все рестораны</a>
            <a href="#" class="no_text_select" id="show_random">Случайный выбор</a>
            <a href="#" class="no_text_select" id="show_chars">По алфавиту</a>
        </div>
        <div id="login_block">
            <xsl:choose>
                <xsl:when test="//user/is_auth=1">
                    <a href="/blog/profile/{//user/user_login}">
                        <xsl:value-of select="//user/user_login" />
                    </a>
                    <xsl:text> (</xsl:text>
                    <a href="/{//site/city}/auth/logout" style="text-decoration:none;">выход</a>
                    <xsl:text>) </xsl:text>
                    <br />
                    <xsl:text>Настройки </xsl:text>
                    <a href="/blog/settings/profile/">профиля</a>
                </xsl:when>
                <xsl:otherwise>
                    <a href="#" id="login">Войти</a> /
                    <a href="#" id="registration">Регистрация</a>
                </xsl:otherwise>
            </xsl:choose>
        </div>
        <div class="clear"></div>
        <!-- Панель настроений -->
        <div id="moods_container">
            <div id="moods">
                <div id="bar_top">
                    <div id="bar" style="width:4000px;">
                        <xsl:apply-templates select="//moods/item" />
                    </div>
                </div>
                <div id="cursor_top" class="rounded">
                    <div class="left_text">Посерьёзней</div>
                    <div id="cursor">
                        <div class="scroll_left"></div>
                        <div class="scroll_right"></div>
                    </div>
                    <div class="right_text">Повеселее</div>
                </div>
            </div>
        </div>
        <!-- Панель выбора по алфавиту -->
        <div id="chars_container">
            <div id="chars">
                <div class="chars_line">
                    <div class="left"></div>
                    <div class="center">
                        <div class="items">
                            <xsl:call-template name="chars_list_rus"/>
                        </div>
                    </div>
                    <div class="right"></div>
                </div>
                <div class="clear"></div>
                <div class="chars_line">
                    <div class="left"></div>
                    <div class="center">
                        <div class="items">
                            <xsl:call-template name="chars_list_number"/>
                        </div>
                    </div>
                    <div class="right"></div>
                </div>
            </div>
        </div>
        <!-- Панель поиска -->
        <div id="search_container">
            <div id="search">
                <div id="search_types">
                    <a href="#" class="search_by active" id="search_by_rest">по названию</a>
                    <a href="#" class="search_by" id="search_by_cook">по кухням</a>
                    <a href="#" class="search_by" id="search_by_music">по музыке</a>
                    <a href="#" class="search_by" id="search_by_category">по типу заведения</a>
                    <a href="#" class="search_by" id="search_by_menu">по меню</a>
                    <a href="#" class="search_by" id="search_by_address">по адресу</a>
                </div>
                <div id="search_form">
                    <div class="ajax_form">
                        <input id="search_text" type="text" class="input rounded" name="search" />
                        <input type="button" class="button" value="Найти"/>
                    </div>
                    <div class="clear"></div>
                </div>
                <div id="search_sample">
                    например,
                    <a href="#" onclick="$('#search_text').val($(this).html());">суши-бар</a>
                </div>
            </div>
        </div>
        <div id="random_container"></div>
        <div id="all_container"></div>
        <!-- Список ресторанов по настроению -->
        <div id="restaurant_by_mood">
            <xsl:call-template name="restaurant_by_mood_navigate_top" />
            <div id="restaurant_by_mood_content">
                <!-- Сюда загружается список ресторанов -->
            </div>
            <div class="clear"></div>
        </div>
    </xsl:template >

    <!-- Список настроений -->
    <xsl:template match="moods/item">
        <div class="icon rounded no_text_select" uri="{uri}">
            <div class="count">
                <xsl:value-of select="rest_count" />
            </div>
            <img src="http://images.foodfood.ru/moods/{uri}.png" alt="{caption}" />
            <a href="#mood-{uri}" class="caption">
                <xsl:value-of select="title" />
            </a>
        </div>
    </xsl:template>

    <!-- Footer -->
    <xsl:template name="footer">
        <div id="copyright">
            <div class="left">&#169; 2010 Diar group
                <br />
                <br />Дизайн —
                <a href="http://bpirok.ru">Большой Пирок</a>
            </div>
            <div class="smi">
                <a href="/{//site/city}/content/about">О проекте</a>
                <a href="/{//site/city}/content/ads">Реклама</a>
                <a  href="#" id="callback">Обратная связь</a>
                <br />
                <br />
                При полном или частичном цитировании,
                заимствовании, использовании ссылка обязательна.
            </div>
            <div class="right">
                Присоединяйся к нам!
                <br />
                <br />
                <a href="http://www.facebook.com/profile.php?id=100001264771648" class="social fb" title="Мы в FaceBook">
                </a>
                <a href="http://foodfoodru.livejournal.com/" class="social lj" title="Мы в ЖЖ">
                </a>
                <a href="http://vkontakte.ru/club16013362 " class="social vk" title="Мы Вконтакте">
                </a>
                <a href="http://twitter.com/foodfoodru" class="social tw"  title="Мы в Twitter">
                </a>
            </div>
        </div>
    </xsl:template>

    <!-- Вывод баннера -->
    <xsl:template match="banner">
        <iframe class="{class}" src="/{//site/city}/banner/{type}/" frameborder="no" scrolling="no"></iframe>
    </xsl:template>

    <!-- Ссылка для ресторана -->
    <xsl:template name="rest_link">
        <xsl:param name="id" />
        <xsl:param name="uri" />
        <xsl:param name="title" />
        <xsl:param name="class" />
        <a>
            <xsl:attribute name="class">
                <xsl:value-of select="$class"/>
            </xsl:attribute>
            <xsl:attribute name="href">
                <xsl:text>/</xsl:text>
                <xsl:value-of select="//site/city" />
                <xsl:text>/restaurant/</xsl:text>
                <xsl:choose>
                    <xsl:when test="$uri!=''">
                        <xsl:value-of select="$uri" />
                    </xsl:when>
                    <xsl:otherwise>
                        <xsl:value-of select="$id" />
                    </xsl:otherwise>
                </xsl:choose>
            </xsl:attribute>
            <xsl:value-of select="$title" />
        </a>
    </xsl:template>
</xsl:stylesheet>