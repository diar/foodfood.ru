<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

    <xsl:template match="/">
        <html>
            <body style="margin:0">
        <xsl:apply-templates select="root/banner" />
        <script type="text/javascript" src="http://www.google.com/jsapi"></script>
        <script type="text/javascript">
                google.load("jquery", "1.4.2");
                google.load("swfobject", "2.2");
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
            $('.swfobject').each(function(){
                src = $(this).find('.src').html();
                id = $(this).find('.id').html();
                width = $(this).find('.width').html();
                height = $(this).find('.height').html();
                $(this).html('');
                swfobject.embedSWF("/upload/flash/banners/"+src, "banner"+id, width, height, "9.0.0");
            }).show();
            });
        </script>
        </body>
        </html>
    </xsl:template>

    <xsl:template match="root/banner">
        <xsl:choose>
            <xsl:when test="type = 'image'">
                <a href="/public/ajax/banner.php?redirect={href}&amp;banner={id}&amp;city=kazan" style="border:none;">
                    <img src="/upload/image/banners/{src}" id="banner{id}" style="border:none;" />
                </a>
            </xsl:when>
            <xsl:when test="type = 'flash'">
                <div>
                    <div id="banner{id}" class="swfobject" style="display:none">
                        <div class="src"><xsl:value-of select="src" /></div>
                        <div class="width"><xsl:value-of select="width" /></div>
                        <div class="height"><xsl:value-of select="height" /></div>
                        <div class="id"><xsl:value-of select="id" /></div>
                    </div>
                </div>
            </xsl:when>
        </xsl:choose>
    </xsl:template>

</xsl:stylesheet>
