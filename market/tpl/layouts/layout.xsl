<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>
    <!-- Макет -->
    <xsl:template match="root">
        <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
            <head>
                <title> Доставка пиццы суши и ролл в Казани</title>
                <meta name="keywords" content="{site/keywords}" />
                <meta name="description" content="{site/description}" />
                <link rel="icon" type="image/vnd.microsoft.icon"  href="/public/images/favicon.ico" />
                <link rel="stylesheet" type="text/css" href="/public/css/style.css" />
                <link rel="stylesheet" type="text/css" href="/public/js/libs/lightbox/css/jquery.lightbox.css" />
                <xsl:comment><![CDATA[[if IE]>
                <link href="/public/css/ie.css" rel="stylesheet" type="text/css" />
                <![endif]]]>
                </xsl:comment>
            </head>
            <body>
                <xsl:apply-templates select="header" />
                
				<script type="text/javascript">
                    <xsl:text>user_auth = '</xsl:text>
                    <xsl:value-of select="//user/is_auth" />';
                </script>
                <script type="text/javascript" src="/public/js/libs/libs.js"></script>
                <script type="text/javascript" src="/public/js/libs/lightbox/js/jquery.lightbox.pack.js"></script>
                <script type="text/javascript" src="/public/js/system.js"></script>
                <script type="text/javascript" src="/public/js/main.js"></script>
            </body>
        </html>
    </xsl:template>

    <!-- Заголовок страницы -->
    <xsl:template match="header">
        <table>
	<tr class="header">
    	<td class="left">
        	<div class="logo">
				<a href="/" alt="FFMarket.ru"><img src="/public/images/logo.jpg" alt="FF Market" /></a><br />
                <div class="logo_desc">
                    Интернет магазин
                    натуральной еды
                </div>
            </div>
        </td>
        <td class="margin"></td>
        <td class="right">
	        <div class="telephone">Телефон магазина: +7 (843) 5700 921</div>
        	<div class="banner">
				<img src="/public/images/banner.jpg" alt="banner" />
            </div>
            <div class="menu">
				<a href="#">Помощь</a><a href="#">Доставка</a><a href="#">Оплата</a><a href="#">Точки самовывоза</a><a href="#">Оптовая продажа</a>
            </div>
        </td>
    </tr>
    <tr class="menu">
    	<td></td>
        <td></td>
        <td class="lk_menu"><xsl:if test="//user/is_auth = 1"><a href="/user/view/{//user/user_id}"><xsl:value-of select="//user/user_login" /></a>, <a href="/user/logout">выход</a></xsl:if></td>
    </tr>
    <tr class="body">
    	<td class="left">
        	<div class="leftPadding">
                <div class="lk">
                <xsl:choose>
                	<xsl:when test="//user/is_auth = 1">
                    <div id="trash">
                        <a href="/user/trash">Корзина</a><br />
						<xsl:if test="//trash/price > 0">Заказ на <span id="trash_gen_price"><xsl:value-of select="//trash/price" /></span> Р</xsl:if>
                    </div>
                 	</xsl:when>
                    <xsl:otherwise>
	                    <div id="reg_enter">
        	                <a href="/user/auth">Войти</a> / <a href="/user/registration">Регистрация</a>
    	                </div>
                    </xsl:otherwise>
                </xsl:choose>
                </div>
            </div>
            <ul class="menu">
            	<li><a href="/">Все товары</a></li>
                <li><a href="/product/list/new">Новые товары</a></li>
                <li><a href="/product/list/sale">Товары со скидкой</a></li>
            </ul>

            <xsl:value-of select="tree" disable-output-escaping="yes"  />
        </td>
            <td class="margin"></td>
            <td class="right">
                <xsl:apply-templates select="content"  />
            </td>
        </tr>
    </table>

    </xsl:template>




    
</xsl:stylesheet>