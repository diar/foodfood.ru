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
    <!-- Макет -->
    <xsl:template match="root">
        <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
            <head>
                <title> Доставка пиццы суши и ролл в Казани</title>
                <meta name="keywords" content="{site/keywords}" />
                <meta name="description" content="{site/description}" />
                <link rel="icon" type="image/vnd.microsoft.icon"  href="/public/images/favicon.ico" />
                <link rel="stylesheet" type="text/css" href="/market/public/css/style.css" />
                <link rel="stylesheet" type="text/css" href="/public/js/libs/lightbox/css/jquery.lightbox.css" />
                <xsl:comment><![CDATA[[if IE]>
                <link href="/public/css/ie.css" rel="stylesheet" type="text/css" />
                <![endif]]]>
                </xsl:comment>
            </head>
            <body>
                <div id="container">
                    <xsl:apply-templates select="header" />
                    <div class="clear"></div>
                    <xsl:apply-templates select="content" />
                    <xsl:call-template name="order_dialog" />
                    <xsl:call-template name="auth_dialog" />
                    <xsl:call-template name="registration_dialog" />
                    <xsl:call-template name="message_dialog" />
                    <xsl:call-template name="passwd_dialog" />
                </div>
                <script type="text/javascript">
                    <xsl:text>site_city = '</xsl:text>
                    <xsl:value-of select="site/city" />';
                    <xsl:text>user_auth = '</xsl:text>
                    <xsl:value-of select="//user/is_auth" />';
                </script>
                <script type="text/javascript" src="/market/public/js/libs/libs.js"></script>
                <script type="text/javascript" src="/public/js/libs/lightbox/js/jquery.lightbox.pack.js"></script>
                <script type="text/javascript" src="/market/public/js/system.js"></script>
                <script type="text/javascript" src="/market/public/js/main.js"></script>
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
           
            <div class="clear"></div>
        </div>
        <div id="topMenu">
            <xsl:apply-templates select="../menu/item" />
        </div>
        <div id="info_block">
            <table>
                <tr>
                    <td class="first_col">
                        <div class="font21px">Выбери район доставки</div>
                        <div class="font12px">Обратите внимание, что от района доставки зависит меню блюд.</div>
                        <div class="select">
                            <xsl:value-of select="//content/locations/item[1]/title" />
                        </div>
                        <select id="locate_select" class="clear_opacity">
                            <option value="0">Выберите район</option>
                            <xsl:apply-templates select="//content/locations/item" />
                        </select>
                    </td>
                    <td>
                        <div class="trash">
                            <div class="money">
                                <div class="">Твой общий счет</div>
                                <div class="rub"><xsl:value-of select="//trash/price" /><sup> руб.</sup></div>
                            </div>
                            <div class="order">
                                <xsl:if test="//trash/count=0">
                                    <xsl:attribute name="style">display:none;</xsl:attribute>
                                </xsl:if>
                                <a href="#">Корзина</a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="trash_description">
                            <xsl:value-of select="//trash/description" disable-output-escaping="yes" />
                        </div>
                    </td>
                    <td>
                        <div id="login_block">
                            <xsl:choose>
                                <xsl:when test="//user/is_auth=1">
                                    <a href="/blog/profile/"><xsl:value-of select="//user/user_login" /></a>
                                    <xsl:text> (</xsl:text>
                                    <a href="/{//site/city}/auth/logout" style="text-decoration:none;">выход</a>
                                    <xsl:text>) </xsl:text><br /><xsl:text>Настройки </xsl:text>
                                    <a href="/blog/settings/profile/">профиля</a>
                                </xsl:when>
                                <xsl:otherwise>
                                    <a href="#" id="login">Войти</a> / <a href="#" id="registration">Регистрация</a>
                                </xsl:otherwise>
                            </xsl:choose>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </xsl:template >

    <!-- Footer -->
    <xsl:template name="footer">

    </xsl:template>

    <!-- Вывод баннера -->
    <xsl:template match="banner">
        <iframe class="{class}" src="/{//site/city}/banner/{type}/" frameborder="0" scrolling="no"></iframe>
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

    <xsl:template match="locations/item">
        <option value="{id}">
            <xsl:if test="//content/current_location=id">
                <xsl:attribute name="selected">true</xsl:attribute>
            </xsl:if>
            <xsl:value-of select="title" />
        </option>
    </xsl:template>
</xsl:stylesheet>