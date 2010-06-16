<?xml version="1.0" encoding="UTF-8"?>
<!-- Страница для получения списка ресторанов по настроению через Ajax -->
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>
    <xsl:template match="/">
        <xsl:apply-templates select="root/person" />
    </xsl:template>

    <!-- Список ресторанов -->
    <xsl:template match="person">
        <div class="left">
            <div class="img"><img src="/upload/image/persons/{uri}.jpg" alt="{person_name}"  /></div>
        </div>
        <div class="right">
            <div class="name"><xsl:value-of select="person_name" /></div>
            <div class="date">25.05.2010</div>
            <div class="clear"></div>
            <div class="job"><xsl:value-of select="person_post" /></div>
            <div class="interview">
                <xsl:apply-templates select="person_questions/item" />
            </div>
        </div>
        <div class="clear"></div>
    </xsl:template>

    <xsl:template match="person_questions/item">
        <div class="int">
            <span class="quest">
                <xsl:if test="position()=1">
                    <xsl:attribute name="class">quest active</xsl:attribute>
                </xsl:if>
                <xsl:value-of select="q" />
            </span>
            <div class="answer">
                <xsl:if test="position()=1">
                    <xsl:attribute name="style">display:block;</xsl:attribute>
                </xsl:if>
                <xsl:value-of select="a" />
            </div>
        </div>
    </xsl:template>
</xsl:stylesheet>