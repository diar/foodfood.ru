<?xml version="1.0" encoding="UTF-8"?>
<!-- Страница авторизации -->
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

    <!-- Импорт макета -->
    <xsl:include href="../../layouts/light.xsl" />
    <xsl:template match="/">
        <xsl:apply-templates select="root/content" />
    </xsl:template >

    <!-- Код страницы -->
    <xsl:template match="root/content">
        <input type="text" />
        <input type="password" />
    </xsl:template >

</xsl:stylesheet>