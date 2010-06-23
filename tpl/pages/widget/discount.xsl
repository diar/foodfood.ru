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
                <xsl:call-template name="rest_link">
                    <xsl:with-param name="id" select="rest_id" />
                    <xsl:with-param name="uri" select="rest_uri" />
                    <xsl:with-param name="title" select="rest_title" />
                </xsl:call-template>
                <div class="left">Осталось: <xsl:value-of select="discount_count" /></div>
            </div>
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