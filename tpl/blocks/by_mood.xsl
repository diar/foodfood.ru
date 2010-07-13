<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>
    <!-- Панель навигации у списка ресторанов верхняя -->
    <xsl:template name="restaurant_by_mood_navigate_top">
        <div class="restaurant_navigate rounded">
            <div class="back"></div>
            <div class="caption">Настроение: Пятница</div>
            <div class="next"></div>
            <div style="float:right;margin-right:20px;font-size:12px;">
                <span class="page_current"></span> страничка из <span class="page_count"></span>
            </div>
        </div>
        <div class="restaurant_tags">
            <xsl:apply-templates select="//content/tags/item" />
        </div>
        <div class="clear"></div>
    </xsl:template>
    <!-- Панель навигации у списка ресторанов нижняя -->
    <xsl:template name="restaurant_by_mood_navigate_bottom">
        <div class="restaurant_navigate rounded">
            <div class="back"></div>
            <div class="caption">Настроение: Пятница</div>
            <div class="next"></div>
            <div style="float:right;margin-right:20px;font-size:12px;">
                <span class="page_current"></span> страничка из <span class="page_count"></span>
            </div>
        </div>
        <div class="clear"></div>
    </xsl:template>

    <xsl:template match="//content/tags/item">
        <div class="item rounded" tag="{id}">
            <div class="img">
                <img src="http://images.foodfood.ru/tags/{uri}.png" alt="{title}" />
            </div>
            <div class="text"><xsl:value-of select="title" /></div>
        </div>
    </xsl:template>
</xsl:stylesheet>