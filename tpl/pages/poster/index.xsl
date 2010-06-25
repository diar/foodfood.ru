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
            current_year = <xsl:value-of select="//date_today/year" />;
            current_month = <xsl:value-of select="//date_today/month_number" />;
            current_day = <xsl:value-of select="//date_today/day" />;
            current_week = '<xsl:value-of select="//date_today/week" />';
        </script>
        <div id="additional">
            <div class="afisha_list">
                <div id="mounth_list">
                    <div class="back"></div>
                    <div id="mounth">
                        <div id="mounths_conteiner">
                            <xsl:apply-templates select="months/item" />
                        </div>
                    </div>
                    <div class="next"></div>
                </div>
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
                <div class="anounce_block"></div>
                <div class="clear"></div>
            </div>
        </div>
    </xsl:template>

    <xsl:template match="dates/item">
        <div class="item" offset="{day}">
            <div><xsl:value-of select="day" /><sup><xsl:value-of select="week" /></sup></div>
        </div>
    </xsl:template>

    <xsl:template match="months/item">
        <div class="item" month="{month}" year="{year}">
            <div><xsl:value-of select="word" /></div>
        </div>
    </xsl:template>
</xsl:stylesheet>