<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="xml" version="1.0" encoding="UTF-8" indent="yes" />
    <xsl:template match="/">
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
            <xsl:apply-templates select="root/content/item" />
        </urlset>
    </xsl:template>

    <xsl:template match="content/item">
        <url>
            <loc><xsl:value-of select="loc" /></loc>
            <xsl:if test="lastmod!=''">
                <lastmod><xsl:value-of select="lastmod" /></lastmod>
            </xsl:if>
            <xsl:if test="changefreq!=''">
                <changefreq><xsl:value-of select="changefreq" /></changefreq>
            </xsl:if>
            <xsl:if test="priority!=''">
                <priority><xsl:value-of select="priority" /></priority>
            </xsl:if>
        </url>
    </xsl:template>
</xsl:stylesheet>
