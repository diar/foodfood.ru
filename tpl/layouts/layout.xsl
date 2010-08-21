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
                    <xsl:value-of select="//site/title" />
                </title>
                <meta name="keywords" content="{site/keywords}" />
                <meta name="description" content="{site/description}" />
                <link rel="icon" type="image/vnd.microsoft.icon"  href="/public/images/favicon.ico" />
                <link rel="stylesheet" type="text/css" href="/public/css/style.css" />
                <link rel="stylesheet" type="text/css" href="/public/css/main.css" />
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
                <xsl:if test="//user/is_auth!=1">
                    <xsl:call-template name="auth_dialog" />
                    <xsl:call-template name="registration_dialog" />
                    <xsl:call-template name="passwd_dialog" />
                </xsl:if>
                <xsl:call-template name="discount_dialog" />
                <xsl:call-template name="message_dialog" />
                <xsl:call-template name="callback_dialog" />
                
                <script type="text/javascript">
                    <xsl:text>site_city = '</xsl:text>
                    <xsl:value-of select="site/city" />
                    <xsl:text>';</xsl:text>
                    <xsl:text>user_auth = '</xsl:text>
                    <xsl:value-of select="//user/is_auth" />
                    <xsl:text>';</xsl:text>
                </script>
                <script type="text/javascript" src="/public/js/libs/libs.js"></script>
                <script type="text/javascript" src="/public/js/system.js"></script>
                <script type="text/javascript" src="/public/js/moods.js"></script>
                <script type="text/javascript" src="/public/js/main.js"></script>
                <!--LiveInternet counter-->
                <script type="text/javascript"><!--
                    document.write("<a href='http://www.liveinternet.ru/click' "+
                    "target=_blank><img src='//counter.yadro.ru/hit?t44.6;r"+
                    escape(document.referrer)+((typeof(screen)=="undefined")?"":
                    ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
                    screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
                    ";"+Math.random()+
                    "' alt='' title='LiveInternet' "+
                    "border='0' width='31' height='31'><\/a>")
                //-->
                </script><!--/LiveInternet-->
                <script type="text/javascript">
                    var _gaq = _gaq || [];
                    _gaq.push(['_setAccount', 'UA-13029839-2']);
                    _gaq.push(['_trackPageview']);

                    (function() {
                    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                    })();
                </script>
                <!-- Yandex.Metrika -->
                <script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript"></script>
                <div style="display:none;">
                    <script type="text/javascript">
                    try { var yaCounter1192696 = new Ya.Metrika(1192696); } catch(e){}
                    </script>
                </div>
                <noscript>
                    <div style="position:absolute">
                        <img src="//mc.yandex.ru/watch/1192696" alt="" />
                    </div>
                </noscript>
                <!-- /Yandex.Metrika -->
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
                    <xsl:choose>
                        <xsl:when test="//user/message_count!=0">
                            <a href="/blog/talk/" class="message" id="new_messages">
                                <xsl:value-of select="//user/message_count" />
                            </a>
                        </xsl:when>
                        <xsl:otherwise>
                            <a href="/blog/talk/" class="message-empty" id="new_messages"> </a>
                        </xsl:otherwise>
                    </xsl:choose>
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
                    <a href="#" class="search_by" id="search_by_cook">по кухне</a>
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
        <div class="clear"></div>
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
            <div class="img_icon_in_bg" style="background-position:-{(position()-1)*130}px 0;" title="{caption}">
                <br />
            </div>
            <a href="#mood-{uri}" title="{title}" class="caption">
                <xsl:value-of select="title" />
            </a>
        </div>
    </xsl:template>

    <!-- Footer -->
    <xsl:template name="footer">
        <div id="footer">
            <div id="footer_left">
                <div class="caption rounded_right">Новости портала FF</div>
                <ul>
                    <xsl:apply-templates select="//content/news/item" />
                </ul>
            </div>
            <div id="footer_center">
                <div class="title">Привет,
                    <xsl:value-of select="//statistic/people" />-й посетитель!
                </div>
                <div class="text">
                    На портале представлены
                    <xsl:value-of select="//statistic/restaurant" /> кафе и
                    ресторанов города Казани с меню, фотографиями и отзывами.
                    Есть возможность заказать банкет, забронировать стол, получить скидку и конечно же осуществить
                    доставку еды. 
                    <br />
                    <br />
                    Каждому посетителю портала будет доступно в интерактивной форме:
                    Выбор ресторана; Просмотр меню; Афиши; Интерьера;Отзывы и рекомендации;
                    Скидки в кафе и ресторане; Доставка блюд, а так же удобный сервис по проведению банкетов.
                    Настроение есть!
                </div>
            </div>
            <div id="footer_right">
                <div class="person_block">
                    <xsl:choose>
                        <xsl:when test="//person!=''">
                            <div class="caption">Приятного аппетита желает:</div>
                            <div class="photo">
                                <a href="/{//site/city}/persons/view/{//person/id}">
                                    <img src="http://uploads.foodfood.ru/image/persons/medium-{//person/uri}.jpg" alt="{//person/person_name}" />
                                </a>
                            </div>
                            <div class="text">
                                <div class="fio">
                                    <a href="/{//site/city}/persons/view/{//person/id}">
                                        <xsl:value-of select="//person/person_name" />
                                    </a>
                                </div>
                                <xsl:value-of select="//person/person_post" />
                                <br />
                                <br />
                                <xsl:value-of select="//person/person_text" />
                            </div>
                            <div class="clear"></div>
                        </xsl:when>
                    </xsl:choose>
                </div>
                <div class="clear"></div>
            </div>
        </div>
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
                <noindex>
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
        <iframe class="{class}" src="/{//site/city}/banner/{type}/" frameborder="0" scrolling="no"></iframe>
    </xsl:template>

    <xsl:template match="//news/item">
        <li>
            <a href="/{//site/city}/news/{id}">
                <xsl:value-of select="title" />
            </a>
        </li>
    </xsl:template>
    
    <!-- Ссылка на ресторан -->
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