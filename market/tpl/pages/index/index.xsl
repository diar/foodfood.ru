<?xml version="1.0" encoding="UTF-8"?>
<!-- Главная страница -->
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

    <!-- Импорт макета -->
    <xsl:include href="../../layouts/layout.xsl" />
    <xsl:template match="/">
        <xsl:apply-templates select="root" />
    </xsl:template >

    <!-- Код страницы -->
    
    <xsl:template match="content">
    	<div style="width:100%;text-align:center;font-size:32px; font-family:Tahoma,Arial;padding-top:40px;">
        	Наполняем прилавки...<br /><br />
            <span style="color:#999999; font-style:italic;">Открытие 20 августа</span>
        </div>
    </xsl:template>
    
    <xsl:template match="content_old">
        <div id="info_block">
            <table>
                <tr>
                    <td class="first_col">
                        <div class="font21px">Выбери район доставки</div>
                        <div class="font12px">Обратите внимание, что от района доставки зависит меню блюд.</div>
                        <div class="select"><xsl:value-of select="locations/item[1]/title" /></div>
                        <select id="locate_select" class="clear_opacity">
                            <xsl:apply-templates select="locations/item" />
                        </select>
                        <div class="remember"><input type="checkbox" /> запомнить район</div>
                    </td>
                    <td>
                        <div class="trash">
                            <div class="money">
                                <div class="">Твой общий счет</div>
                                <div class="rub"><xsl:value-of select="//trash/price" /><sup> руб.</sup></div>
                                <div class="edit"><a href="#">Корректировать</a></div>
                            </div>
                            <div class="order">
                                <xsl:if test="//trash/count=0">
                                    <xsl:attribute name="style">display:none;</xsl:attribute>
                                </xsl:if>
                                <a href="#">Оформить заказ</a>
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
        <div class="navigation rounded">
            <div class="back"></div>
            <div class="menu">
                <ul>
                    <xsl:apply-templates select="menu_types/item" />
                </ul>
            </div>
            <div class="pages">Страничка 1 из 5</div>
            <div class="next"></div>
        </div>
        <div id="menu_list">
            <!-- Сюда загружается страница с блюдами -->
        </div>
        <div class="navigation rounded">
            <div class="back"></div>
            <div class="pages">Страничка 1 из 5</div>
            <div class="next"></div>
        </div>
    </xsl:template >

    <xsl:template match="locations/item">
        <option value="{id}"><xsl:value-of select="title" /></option>
    </xsl:template>

    <xsl:template match="menu_types/item">
        <li id="{id}"><a href="#" ><xsl:value-of select="title" /></a></li>
    </xsl:template>

</xsl:stylesheet>