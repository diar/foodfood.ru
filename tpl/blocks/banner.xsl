<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>
    <!-- Вывод баннера -->
    <xsl:template match="banner">
        <xsl:choose>
            <xsl:when test="tid!=''">
                <iframe class="{class}" src="/{//site/city}/banner/{type}/?tid={tid}" frameborder="0" scrolling="no"></iframe>
            </xsl:when>
            <xsl:otherwise>
                <iframe class="{class}" src="/{//site/city}/banner/{type}/" frameborder="0" scrolling="no"></iframe>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

</xsl:stylesheet>