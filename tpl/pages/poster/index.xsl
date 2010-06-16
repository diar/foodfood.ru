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

    <!-- Код страницы -->
    <xsl:template match="content">
        <script type="text/javascript">
            poster_page_activate = true;
        </script>
        <div id="additional">
            <div class="restaurant_header rounded">
                <div class="caption">
                    <div class="title">Афиша</div>
                </div>
            </div>

            <div class="afisha_list">
            	
                <div class="date_list">
                    <div class="back"></div>
                    <div class="items">
                        <div class="inner">
                            <xsl:apply-templates select="dates/item" />
                        </div>
                    </div>
                    <div class="next"></div>
                </div>
                <div class="clear"></div>
                <div class="by_date today">
                    <div class="current_date">
                        <div class="calendar_layout today">
                            <div class="calendar box_shadow">
                                <div class="month"><xsl:value-of select="//date_today/day" /></div>
                                <div class="number" style="background:#ff6600"><xsl:value-of select="//date_today/month" /></div>
                            </div>
                            <div class="text">сегодня</div>
                        </div>
                    </div>
                    <div class="list">
                        <xsl:apply-templates select="poster_today/item" />
                        <div class="clear"></div>
                    </div>
                    <div class="right_banner"></div>
                </div>
                <div class="clear"></div>
                <div class="by_date tomorrow">
                    <div class="current_date">
                        <div class="calendar_layout">
                            <div class="calendar box_shadow">
                                <div class="month"><xsl:value-of select="//date_tomorrow/day" /></div>
                                <div class="number"><xsl:value-of select="//date_tomorrow/month" /></div>
                            </div>
                            <div class="text">завтра</div>
                        </div>
                    </div>
                    <div class="list">
                        <xsl:apply-templates select="poster_tomorrow/item" />
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                    <div class="bottom"></div>
                </div>
            </div>

        </div>
    </xsl:template>

    <xsl:template match="dates/item">
        <div class="item" offset="{offset}">
            <div><xsl:value-of select="week" /></div>
            <xsl:value-of select="day" />
        </div>
    </xsl:template>

    <xsl:template match="poster_today/item">
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

    <xsl:template match="poster_tomorrow/item">
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