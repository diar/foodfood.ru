<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="text" encoding="utf-16"/>

    <xsl:template match="/">
        <xsl:apply-templates select="root/item"/>
    </xsl:template>

    <xsl:template match="root/item">
        <xsl:for-each select="*">
            <xsl:value-of select="."/>
            <xsl:if test="position() != last()">
                <xsl:value-of select="';'"/>
            </xsl:if>
        </xsl:for-each>
        <xsl:text>&#13;&#10;</xsl:text>
    </xsl:template>

</xsl:stylesheet>