<?xml version="1.0" encoding="UTF-8"?>
<!-- Страница для получения списка ресторанов по настроению через Ajax -->
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>
    <xsl:template match="/">
        <xsl:apply-templates select="root" />
    </xsl:template>

    <!-- Список ресторанов -->
    <xsl:template match="root">
        <script type="text/javascript">
            poster_page_activate = true;
        </script>
        <div class="current_date">
            <div class="calendar_layout today">
                <div class="calendar box_shadow">
                    <div class="month"><xsl:value-of select="//date/day" /></div>
                    <div class="number" style="background:#ff6600"><xsl:value-of select="//date/month" /></div>
                </div>
            </div>
        </div>
        <div class="list">
            <xsl:apply-templates select="poster/item" />
            <div class="clear"></div>
        </div>
        <div class="right_banner"></div>
    </xsl:template>

     <xsl:template match="poster/item">
        <div class="item">
            <div class="foto box_shadow">
                <xsl:choose>
                    <xsl:when test="img=''">
                        <img src="/public/images/poster_icon.jpg" alt="{title}" />
                    </xsl:when>
                    <xsl:otherwise>
                        <img src="/upload/image/poster/{img}" alt="{title}" />
                    </xsl:otherwise>
                </xsl:choose>
            </div>
            <div class="info">
                <div class="caption"><a href="/{//site/city}/poster/view/{rest_poster_id}">
                        <xsl:value-of select="title" />
                </a></div>
                <div class="rest_name"><xsl:value-of select="rest_title" /></div>
                <div class="description"><xsl:value-of select="anounce" /></div>
            </div>
        </div>
    </xsl:template>
    
</xsl:stylesheet>