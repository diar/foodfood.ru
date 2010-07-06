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
        <xsl:apply-templates select="content/news/items/item" />
        <xsl:apply-templates select="content/actions/items/item" />
        <xsl:apply-templates select="content/posters/items/item" />
    </xsl:template>

    <xsl:template match="items/item">
        <item>
            <title>
                <xsl:value-of select="title" />
            </title>
            <link>http://foodfood.ru/<xsl-value-of select="//site/city" />/poster/view/<xsl-value-of select="rest_poster_id" /></link>
            <description>
                <xsl:value-of select="anounce" />
            </description>
            <pubDate><xsl:value-of select="date" /></pubDate>
            <guid>http://foodfood.ru/<xsl-value-of select="//site/city" />/poster/view/<xsl-value-of select="rest_poster_id" /></guid>
        </item>
    </xsl:template>

</xsl:stylesheet>