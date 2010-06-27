<?xml version="1.0" encoding="UTF-8"?>
<!-- Страница для получения списка ресторанов по настроению через Ajax -->
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>
    <xsl:template match="/">
        <div class="page_count" style="display:none;">
            <xsl:value-of select="root/page_count" />
        </div>
        <xsl:apply-templates select="root/restaurants/item" />
    </xsl:template>

    <!-- Список ресторанов -->
    <xsl:template match="restaurants/item">
        <div class="item rounded">
            <xsl:choose>
                <xsl:when test="position()&lt;//item_count">
                    <div class="img">
                        <a>
                            <!-- Begin Создаем ссылку в зависимости от того, есть ли uri -->
                            <xsl:attribute name="href">
                                <xsl:text>/</xsl:text>
                                <xsl:value-of select="//site/city" />
                                <xsl:text>/restaurant/</xsl:text>
                                <xsl:choose>
                                    <xsl:when test="rest_uri!=''">
                                        <xsl:value-of select="rest_uri" />
                                    </xsl:when>
                                    <xsl:when test="rest_uri=''">
                                        <xsl:value-of select="id" />
                                    </xsl:when>
                                </xsl:choose>
                                <xsl:choose>
                                    <xsl:when test="//mood!=''">
                                        <xsl:text>-</xsl:text>
                                        <xsl:value-of select="//mood" />
                                        <xsl:text>-</xsl:text>
                                        <xsl:value-of select="position()" />
                                    </xsl:when>
                                    <xsl:when test="//char!=''">
                                        <xsl:text>-</xsl:text>
                                        <xsl:value-of select="//char" />
                                        <xsl:text>-</xsl:text>
                                        <xsl:value-of select="position()" />
                                    </xsl:when>
                                </xsl:choose>
                            </xsl:attribute>
                            <!-- End Создаем ссылку в зависимости от того, есть ли uri -->
                            <xsl:choose>
                                <xsl:when test="rest_photo=0">
                                    <img src="/public/images/rest_icon.jpg" alt="{rest_title}" />
                                </xsl:when>
                                <xsl:when test="rest_photo=1">
                                    <img src="/upload/image/restaurant/{rest_uri}.jpg" alt="{rest_title}" />
                                </xsl:when>
                            </xsl:choose>
                        </a>
                    </div>
                </xsl:when>
            </xsl:choose>
            <div class="description">
                <div class="logo box_shadow rounded">
                    <xsl:choose>
                        <xsl:when test="rest_logo=''">
                            <img src="/public/images/icons/rest_logo_icon.gif" />
                        </xsl:when>
                        <xsl:otherwise>
                            <img src="/upload/image/rest_logo/{rest_uri}.jpg" />
                        </xsl:otherwise>
                    </xsl:choose>
                </div>
                <div class="name">
                    <a>
                        <xsl:attribute name="href">
                            <xsl:text>/</xsl:text>
                            <xsl:value-of select="//site/city" />
                            <xsl:text>/restaurant/</xsl:text>
                            <xsl:choose>
                                <xsl:when test="rest_uri!=''">
                                    <xsl:value-of select="rest_uri" />
                                </xsl:when>
                                <xsl:when test="rest_uri=''">
                                    <xsl:value-of select="id" />
                                </xsl:when>
                            </xsl:choose>
                            <xsl:choose>
                                <xsl:when test="//mood!=''">
                                    <xsl:text>-</xsl:text>
                                    <xsl:value-of select="//mood" />
                                    <xsl:text>-</xsl:text>
                                    <xsl:value-of select="position()" />
                                </xsl:when>
                                <xsl:when test="//char!=''">
                                    <xsl:text>-</xsl:text>
                                    <xsl:value-of select="//char" />
                                    <xsl:text>-</xsl:text>
                                    <xsl:value-of select="position()" />
                                </xsl:when>
                            </xsl:choose>
                        </xsl:attribute>
                        <xsl:value-of select="rest_title" />
                    </a>
                    <div class="address"><xsl:value-of select="rest_address" /></div>
                </div>
            </div>
        </div>
    </xsl:template>
</xsl:stylesheet>