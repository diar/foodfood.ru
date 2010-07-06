<?xml version="1.0" encoding="UTF-8"?>
<!-- Страница для получения списка ресторанов по настроению через Ajax -->
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"/>

    <xsl:template match="/">
        <rss version="2.0">
            <channel>
                <xsl:apply-templates select="root" />
            </channel>
        </rss>
    </xsl:template>

    <!-- Список ресторанов -->
    <xsl:template match="root">
        <xsl:apply-templates select="content/discounts/item" />
    </xsl:template>

    <xsl:template match="discounts/item">
        <item>
            <title>
                <xsl:value-of select="rest_title" />
            </title>
            <link>http://foodfood.ru//<xsl:value-of select="//site/city"/>/discount#get-<xsl:value-of select="rest_id"/></link>
            <description>
                Скидка <xsl:value-of select="discount_percent" />% в "<xsl:value-of select="rest_title" />".
                Осталось <xsl:value-of select="discount_count" /> шт.
            </description>
            <pubDate><xsl:value-of select="//content/date" /></pubDate>
            <guid>http://foodfood.ru//<xsl:value-of select="//site/city"/>/discount#get-<xsl:value-of select="rest_id"/></guid>
        </item>
    </xsl:template>

</xsl:stylesheet>