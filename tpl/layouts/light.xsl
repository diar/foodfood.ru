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
                <title>
                    <xsl:value-of select="site/page" />
                    <xsl:text> | </xsl:text>
                    <xsl:value-of select="site/title" />
                </title>
                <meta name="keywords" content="{site/keywords}" />
                <meta name="description" content="{site/description}" />
                <link rel="icon" type="image/vnd.microsoft.icon"  href="/public/images/favicon.ico" />
                <link rel="stylesheet" type="text/css" href="/public/css/style.css" />
                <link rel="stylesheet" type="text/css" href="/public/css/main.css" />
                <xsl:comment><![CDATA[[if IE]>
                <link href="/public/css/ie.css" rel="stylesheet" type="text/css" />
                <![endif]]]></xsl:comment>
            </head>
            <body>
                <xsl:apply-templates select="header" />
                <div class="clear"></div>
                <xsl:apply-templates select="content" />
                <xsl:call-template name="footer" />
                <script type="text/javascript" src="/public/js/libs/libs.js"></script>
                <script type="text/javascript" src="/public/js/system.js"></script>
                <script type="text/javascript" src="/public/js/moods.js"></script>
                <script type="text/javascript" src="/public/js/main.js"></script>
            </body>
        </html>
    </xsl:template>

    <xsl:template match="header">
        <div id="header">
            <div id="logo">
                <a href="/"><img src="/public/images/logo.png" alt="Настроение есть!" /></a>
            </div>
        </div>
        <div id="topMenu">
            <xsl:apply-templates select="../menu/item" />
        </div>
    </xsl:template >


    <xsl:template name="footer">
        <div id="footer">
            <div id="footer_left">
                <div class="caption rounded_right">Добавка</div>
                <ul>
                    <li>Введена услуга доставки еды</li>
                    <li>Новый адрес редакции</li>
                    <li>Функция добавления ресторана</li>
                    <li>Новый ресторан Паприкас</li>
                </ul>
            </div>
            <div id="footer_right">
                <div class="caption">Приятного аппетита желает:</div>
                <div class="photo"><img src="/public/images/icons/lico.jpg" /></div>
                <div class="text">
                    <div class="fio">Альбина Сафина</div>
                    Генеральный директор кофейн «Шоколадница<br />
                    <br />
                    С 8 до 12 часов наш шеф-повар удивляет десертами из традиционной французской кухни! С 8 до 12 часов наш шеф-повар удивляет десертами
                </div>
                <div class="clear"></div>
                <div class="more"><a href="#">Все люди</a></div>
                <div class="clear"></div>
            </div>
        </div>
        <div id="copyright">
            <div class="left">Copyright, 2010 DIAR LTD</div>
            <div class="right"><a href="">О проекте</a>    <a href="">Реклама</a> <a href="http://bpirok.ru"><img src="/public/images/icons/bp_icon.jpg" /></a></div>
        </div>
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