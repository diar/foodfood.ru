<?xml version="1.0" encoding="UTF-8"?>
<!-- Страница для получения списка ресторанов по настроению через Ajax -->
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>
    <xsl:template match="/">

            <xsl:apply-templates select="root/dishes/item" />
            <div class="clear"></div>
    </xsl:template>


    <!-- Список блюд -->
    <xsl:template match="dishes/item">
        <div class="item" id="dish_{market_menu_id}" rest_id="{rest_id}">
            <div class="foto">
                <a href="/market/{//site/city}/dish/{market_menu_id}">
                    <xsl:choose>
                        <xsl:when test="img=''">
                            <img src="/public/images/rest_icon.jpg" alt="{title}" />
                        </xsl:when>
                        <xsl:otherwise>
                            <img src="/upload/image/menu/{img}" alt="{title}" />
                        </xsl:otherwise>
                    </xsl:choose>
                </a>
            </div>
            <div class="title">
                <a href="/market/{//site/city}/dish/{market_menu_id}">
                    <xsl:value-of select="title" />
                </a>
            </div>
            <div class="partner">
                <a href="/{//site/city}/restaurant/{rest_uri}">
                        <xsl:value-of select="rest_title" />
                    </a>
            </div>
            <div class="clear"></div>
            <div class="description">
                <xsl:value-of select="description" />
            </div>
            <xsl:comment>
            <div class="portions">
                <xsl:apply-templates select="portions/item" />
            </div>
            
            <div class="price">
                <div class="new">
                    <span><xsl:value-of select="portions/item[1]/price" /></span>
                     руб
                </div>
            </div>
            <div class="get">
                <div class="buy">
                    <a href="#">Заказать</a>
                </div>
            </div>
            </xsl:comment>

            
        </div>
    </xsl:template>

    <!-- Список тэгов -->
    <xsl:template match="menu_tags/item">
        <a href="#" class="menu_tag" tag="{uri}">
            <xsl:if test="current=1">
                <xsl:attribute name="class">menu_tag current</xsl:attribute>
            </xsl:if>
            <xsl:value-of select="title" />
        </a>
    </xsl:template>

    <!-- Порции -->
    <xsl:template match="portions/item">
        
        <span class='portion'>
            <xsl:value-of select="portion" />
            <xsl:if test="second_portion !=''">
                <span class="s_portion">
                       (<xsl:value-of select="second_portion" />)
                </span>
            </xsl:if>
            -
        </span>
         <span class="price"><xsl:value-of select="price" /> р.</span><br />
    </xsl:template>
</xsl:stylesheet>