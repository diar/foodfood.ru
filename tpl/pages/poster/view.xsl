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
            poster_id = <xsl:value-of select="poster/id" />;
        </script>
        <!-- Информация о ресторане -->
        <xsl:apply-templates select="poster" />
    </xsl:template >

    <!-- Информация о лице -->
    <xsl:template match="poster">
        <div id="additional">
            <div class="restaurant_header rounded">
                <div class="caption">
                    <div class="title">Афиша</div>
                </div>
                <xsl:comment>
                    <div style="float:right;margin-right:15px;">
                        <a href="#" id="poster_follow">я пойду!</a>
                    </div>
                </xsl:comment>
            </div>
            <div class="somepage">
                <div class="title">
                    <div class="date">
                        <xsl:value-of select="date_day" /><xsl:text> </xsl:text><xsl:value-of select="date_month" />
                    </div>
                    <div class="caption"><xsl:value-of select="title" /></div>
                </div>
                <div class="text_block">
                    <xsl:choose>
                        <xsl:when test="text!=''">
                            <xsl:value-of select="text" disable-output-escaping="yes" />
                        </xsl:when>
                        <xsl:otherwise>
                            <xsl:value-of select="anounce" disable-output-escaping="yes" />
                        </xsl:otherwise>
                    </xsl:choose>
                </div>
            </div>
        </div>
    </xsl:template>

</xsl:stylesheet>