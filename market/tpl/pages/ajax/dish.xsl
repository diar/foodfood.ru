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
                    <a href="#"><xsl:value-of select="title" /></a>
                </div>
            </div>
            <div class="delivery_desc">
                Доставка заказа от 500 руб. — бесплатно, при заказе до 500 руб.
                стоимость  доставки составляет 90 руб.
            </div>
            <div class="status green">Работаем, всё нормально.</div>
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
            <div class="title"><a href="#"><xsl:value-of select="title" /></a></div>
            <div class="item_tags">
                <div class="tag_item"></div>
                <div class="tag_item"></div>
                <div class="tag_item"></div>
                <div class="tag_item"></div>
            </div>
            <div class="reviews">нет отзывов</div>
            <div class="clear"></div>
            <div class="description"><xsl:value-of select="description" /></div>
            <div class="price">
                <div class="new">
                    <xsl:value-of select="price" />
                    <span> руб</span>
                </div>
                <div class="old"><xsl:value-of select="price_old" /><span> руб</span></div>
            </div>
            <div class="get">
                <input type="button" class="buy" value="Заказать" />
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
</xsl:stylesheet>