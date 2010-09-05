<?xml version="1.0" encoding="UTF-8"?>
<!-- Страница для получения списка ресторанов по настроению через Ajax -->
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>
    <xsl:template match="/">
        <div class="tags">
            <xsl:apply-templates select="//menu_tags/item" />
        </div>
        <xsl:apply-templates select="root/partners/item" />
    </xsl:template>

    <xsl:template match="partners/item">
        <div class="echo">
            <div class="caption green">
                <div class="title text_shadow">
                    <a href="/{//site/city}/restaurant/{dish/item[1]/rest_uri}">
                        <xsl:value-of select="title" />
                    </a>
                </div>
            </div>
            <div class="delivery_desc">
                Доставка заказа от 500 руб. — бесплатно, при заказе до 500 руб.
                стоимость  доставки составляет 90 руб.
            </div>
            <div class="clear"></div>
            <div class="list">
                <xsl:apply-templates select="dish/item" />
                <div class="clear"></div>
            </div>
        </div>
        <div class="page_count" style="display:none;">
            <xsl:value-of select="root/page_count" />
        </div>
    </xsl:template>

    <!-- Список блюд -->
    <xsl:template match="dish/item">
        <div class="item" id="dish_{market_menu_id}" rest_id="{rest_id}">
            <div class="reviews_number">
                <a href="#">7 отзывов</a>
            </div>
            <div class="reviews">
                <a href="#">нет отзывов</a>
            </div>
            <div class="clear"></div>
            <div class="foto">
                <xsl:choose>
                    <xsl:when test="img=''">
                        <img src="/market/public/images/pizza.jpg" alt="{title}" />
                    </xsl:when>
                    <xsl:otherwise>
                        <img src="/upload/image/menu/{img}" alt="{title}" />
                    </xsl:otherwise>
                </xsl:choose>
            </div>
            <div class="title">
                <a href="#">
                    <xsl:value-of select="title" />
                </a>
            </div>
            <div class="clear"></div>
            <div class="description">
                <xsl:value-of select="description" />
            </div>
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
        
        <span class='portion' rel='{price}'>
            <xsl:if test="position() = 1">
                <xsl:attribute name="class">
                    portion active
                </xsl:attribute>
            </xsl:if>
            <xsl:value-of select="portion" />
            <xsl:if test="second_portion !=''">
                <span class="s_portion">
                       (<xsl:value-of select="second_portion" />)
                </span>
                
            </xsl:if>
            <xsl:if test="position() != count(../item)"> <span> / </span></xsl:if>
        </span>
        
    </xsl:template>
</xsl:stylesheet>