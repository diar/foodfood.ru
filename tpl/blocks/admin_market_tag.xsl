<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

    <xsl:template match="/">
        <div id="trash">
            <h3><xsl:value-of select='root/tagsTitle' /></h3>
            <xsl:apply-templates select="root/tags/item" />
        </div>
        <div id="gallery">
            <h3><xsl:value-of select='root/galleryTitle' /></h3>
            <xsl:apply-templates select="root/gallery/item" />
        </div>
        <div class="clear" style="height:20px;"></div>
        <script type="text/javascript" src="/admin/js/market_tag.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
            $.initDrag('gallery','trash','tag','<xsl:value-of select='root/page' />','<xsl:value-of select='root/dish_id' />');
            });
        </script>
    </xsl:template>

    <xsl:template match="item">
        <div class="tag" id="tag{id}"><xsl:value-of select="title" /></div>
    </xsl:template>

</xsl:stylesheet>
