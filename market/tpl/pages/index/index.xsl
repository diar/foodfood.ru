<?xml version="1.0" encoding="UTF-8"?>
<!-- Главная страница -->
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

    <!-- Импорт макета -->
    <xsl:include href="../../layouts/layout.xsl" />
    <xsl:template match="/">
        <xsl:apply-templates select="root" />
    </xsl:template >

    <!-- Код страницы -->
    

    <xsl:template match="content">
		<div class="title" style="margin-left:1em;"><xsl:value-of select="title" /></div>
        <div id="list">
        	<xsl:apply-templates select="products/item" />
        </div>	
        <div class="clear"></div>
    </xsl:template>

    <xsl:template match="products/item"> 
        <div class="item" id="dish_{id}" >
                    <div class="foto">
                        <a href="/product/view/{url}">
                            <img src="/upload/images/products/tmb/{tmb_image}" alt="Ортаги э карни" />
                        </a>
                    </div>
                    <div class="title">
                        <a href="/product/view/{url}"><xsl:value-of select="title" /></a>
                    </div>
                    
                    <div class="clear"></div>
                    <div class="description"><xsl:value-of select="description" /></div>
                    <xsl:choose>
                    	<xsl:when test="discount > 0">
                        <div class="sale"><span><xsl:value-of select="price" /></span> <xsl:value-of select="discount_price" /> Р</div>
                        </xsl:when>
                        <xsl:otherwise>
                        <div class="price"><xsl:value-of select="price" /> Р</div>
                        </xsl:otherwise>
                    </xsl:choose>
                    
		</div>
    </xsl:template>



</xsl:stylesheet>