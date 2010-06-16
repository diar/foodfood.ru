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
                <title>FoodFood Market</title>
                <meta name="keywords" content="{site/keywords}" />
                <meta name="description" content="{site/description}" />
                <link rel="icon" type="image/vnd.microsoft.icon"  href="/public/images/favicon.ico" />
                <link rel="stylesheet" type="text/css" href="/market/public/css/style.css" />
                <link rel="stylesheet" type="text/css" href="/market/public/css/main.css" />
                <xsl:comment><![CDATA[[if IE]>
                <link href="/public/css/ie.css" rel="stylesheet" type="text/css" />
                <![endif]]]></xsl:comment>
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
                <script type="text/javascript" src="http://www.google.com/jsapi"></script>
                <script type="text/javascript">
                    google.load("jquery", "1.4.2");
                    google.load("swfobject", "2.2");
                    site_city = '<xsl:value-of select="site/city" />';
                    user_auth = '<xsl:value-of select="//user/is_auth" />';
                </script>
                <script type="text/javascript" src="/market/public/js/libs/jquery.corner.js"></script>
                <script type="text/javascript" src="/market/public/js/libs/jquery.mousewheel.js"></script>
                <script type="text/javascript" src="/market/public/js/libs/jquery.dropshadow.js"></script>
                <script type="text/javascript" src="/market/public/js/libs/jquery.keyboard.js"></script>
                <script type="text/javascript" src="/market/public/js/libs/jquery.noselect.js"></script>
                <script type="text/javascript" src="/market/public/js/libs/md5.js"></script>
                <script type="text/javascript" src="/market/public/js/system.js"></script>
                <script type="text/javascript" src="/market/public/js/main.js"></script>
            </body>
        </html>
    </xsl:template>

    <!-- Заголовок страницы -->
    <xsl:template match="header">
        <div id="header">
            <div id="logo">
                <a href="/market/">
                    <img src="/market/public/images/logo.png" />
                </a>
            </div>
        </div>
        <div id="menu_top">
            <xsl:apply-templates select="../menu/item" />
            <a href="/market/" class="active">Доставка</a>
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
</xsl:stylesheet>