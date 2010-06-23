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
        <script type="text/javascript" src="http://img.yandex.net/webwidgets/1/WidgetApi.js"></script>
        <script type="text/javascript">
            widget.onload=function(){
            widget.adjustIFrameHeight();
            }
        </script>
        <div id="discounts">
            <xsl:apply-templates select="posters/item/item" />
        </div>
    </xsl:template>

    <xsl:template match="posters/item/item">
        <p class="poster">
            <a href="/{//site/city}/restaurant/{rest_uri}" target="_blank" class="restaurant">
                <xsl:value-of select="rest_title" />
            </a> →
            <a class="poster_title" href="/{//site/city}/poster/view/{rest_poster_id}" target="_blank">
                <xsl:value-of select="title" />
            </a>
        </p>
    </xsl:template>
</xsl:stylesheet>