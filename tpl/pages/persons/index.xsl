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
        <div id="additional">
            <script type="text/javascript">
                person_page_activate = true;
                <xsl:text>person_id = '</xsl:text>
                <xsl:value-of select="person_id" />';
            </script>
            <div class="restaurant_header rounded">
                <div class="margin0autoMax-width1600">
                    <div class="caption">
                        <div class="title">
                            <xsl:comment>
                                <xsl:value-of select="person_title" />
                            </xsl:comment>
                            <span id="person_name_caption"></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="persons_list">
                <div style="width:5000px;">
                    <xsl:apply-templates select="persons/item" />
                </div>
            </div>
            <div class="margin0autoMax-width1600">
                <div id="person"></div>
            </div>
        </div>
    </xsl:template >

    <xsl:template match="persons/item">
        <div class="item" rel="{id}" pos="{position()}">
            <div class="img">
                <img src="/upload/image/persons/mini-{uri}.jpg" />
            </div>
        </div>
    </xsl:template>

</xsl:stylesheet>