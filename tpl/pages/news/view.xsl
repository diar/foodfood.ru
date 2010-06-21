<?xml version="1.0" encoding="UTF-8"?>
<!-- Страница лица фуд фуд -->
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

    <!-- Импорт макета -->
    <xsl:include href="../../layouts/pages.xsl" />
    <xsl:template match="/">
        <xsl:apply-templates select="root" />
    </xsl:template >

    <!-- Содержимое новости -->
    <xsl:template match="content">
        <div class="restaurant_header margin020 rounded">
        	<div class="margin0autoMax-width1600">
            <div class="caption">
                <div class="title"><xsl:value-of select="page/title" /></div>
            </div>
            </div>
        </div>
        <div class="somepage">
            <div class="text_block">
                <xsl:value-of select="page/text" disable-output-escaping="yes" />
            </div>
        </div>

    </xsl:template>

</xsl:stylesheet>