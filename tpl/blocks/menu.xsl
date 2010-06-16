<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>
    <xsl:template match="menu/item">
        <xsl:param name="page" select="//route/page" />
        <a>
            <xsl:attribute name="href">
                <xsl:choose>
                    <xsl:when test="url=''">
                        <xsl:text>/</xsl:text>
                        <xsl:value-of select="//site/city" />
                        <xsl:if test="page!=''">
                            <xsl:text>/</xsl:text>
                            <xsl:value-of select="page" />
                        </xsl:if>
                        <xsl:if test="action!=''">
                            <xsl:text>/</xsl:text>
                            <xsl:value-of select="action" />
                        </xsl:if>
                    </xsl:when>
                    <xsl:otherwise>
                        <xsl:value-of select="url" />
                    </xsl:otherwise>
                </xsl:choose>
            </xsl:attribute>
            <xsl:choose>
                <xsl:when test="$page=page">
                    <xsl:attribute name="class">item current</xsl:attribute>
                </xsl:when>
                <xsl:when test="$page!=page">
                    <xsl:attribute name="class">item</xsl:attribute>
                </xsl:when>
            </xsl:choose>
            <xsl:value-of select="title" />
        </a>
    </xsl:template>
</xsl:stylesheet>