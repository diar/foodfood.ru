<?xml version="1.0" encoding="UTF-8"?>
<!-- Страница для получения списка ресторанов по настроению через Ajax -->
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>
    <xsl:template match="/">
        <xsl:apply-templates select="root/content" />
    </xsl:template>

    <!-- Список ресторанов -->
    <xsl:template match="content">
        <script type="text/javascript" src="http://img.yandex.net/webwidgets/1/WidgetApi.js"></script>
        <script type="text/javascript">
            widget.onload=function(){
            widget.adjustIFrameHeight();
            }
        </script>
        <link rel="stylesheet" type="text/css" href="/public/css/widget.css" />
        <div id="discounts">
            <xsl:apply-templates select="discounts/item" />
        </div>
    </xsl:template>

    <!-- Список скидок -->
    <xsl:template match="discounts/item">
        <div class="discount" partner="{rest_id}" >
            <div class="count rounded">
                <xsl:if test="16 &lt; discount_percent">
                    <xsl:attribute name="class">count sale20</xsl:attribute>
                </xsl:if>
                <xsl:if test="16 &gt; discount_percent">
                    <xsl:attribute name="class">count sale15</xsl:attribute>
                </xsl:if>
                <xsl:if test="6 &gt; discount_percent ">
                    <xsl:attribute name="class">count sale5</xsl:attribute>
                </xsl:if>
                <span class="percent"><xsl:value-of select="discount_percent" /> %</span>
            </div>
            <div class="rest_caption">
                <a href="/{//site/city}/restaurant/{rest_uri}" target="_blank" class="get_discount">
                    <xsl:value-of select="rest_title" />
                </a>
                <div class="left">Осталось: <xsl:value-of select="discount_count" /></div>
            </div>
        </div>
    </xsl:template>
</xsl:stylesheet>