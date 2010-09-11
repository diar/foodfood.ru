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
    
    <xsl:template match="content_old">
    	<div style="width:100%;text-align:center;font-size:32px; font-family:Tahoma,Arial;padding-top:40px;">
        	Наполняем прилавки...<br /><br />
            <span style="color:#999999; font-style:italic;">Открытие 1 сентября</span>
        </div>
    </xsl:template>
    
    <xsl:template match="content">
        <div class="navigation rounded">
            
        </div>
        <table id="main_table">
            <tr>
                <td class="menu_col">
                    <div class="menu">
                        <h3>Категории</h3>
                        <ul id="menu_types">
                                <xsl:apply-templates select="menu_types/item" />
                        </ul>
                        <h3>Рестораны</h3>
                        <ul id="rest_menu">
                            <xsl:apply-templates select="rest_menu/item" />
                        </ul>
                    </div>
                </td>
                <td class="dish_col">
                    <div id="menu_list">
                        <!-- Сюда загружается страница с блюдами -->
                    </div>
                </td>
            </tr>
        </table>
        
    </xsl:template>

    <xsl:template match="menu_types/item">
        <li id="cat-{id}"><a href="#" ><xsl:value-of select="title" /></a></li>
    </xsl:template>

    <xsl:template match="rest_menu/item">
        <li><a href="#" rel="{id}"><xsl:value-of select="rest_title"  /></a></li>
    </xsl:template>

</xsl:stylesheet>