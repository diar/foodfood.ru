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
		 <div id="product">
           <div class="left">
				<div class="title" id="title"><xsl:value-of select="title" /></div>
				<div class="image"><img src="/upload/images/products/{image}" /></div>
				<div class="text">
					<xsl:value-of select="description" disable-output-escaping="yes" />              
                </div>
           </div>
           <div class="right">
           <xsl:if test="is_bio = 1">
           		<div class="es">
                <img src="public/images/es_icon.jpg" alt="Органический продукт.Признано ЕС" align="left" class="es" />
                           <a href="#">Органический <br />
продукт.</a><br />
Признано ЕС
                </div>
                </xsl:if>
                <div class="buy">
                	<form method="post">
                    <xsl:choose>
                    	<xsl:when test="discount > 0">
                        	<div class="price"><span class="bold">Цена: </span> <span style="text-decoration:line-through;" id="old_price"><xsl:value-of select="price" /></span> <span class="sale" id="price"><xsl:value-of select="discount_price" /></span> Р</div>
                        </xsl:when>
                        <xsl:otherwise>
                        	<div class="price"><span class="bold">Цена:</span> <span id="price"><xsl:value-of select="price" /></span>  Р</div>
                        </xsl:otherwise>
                    </xsl:choose>
                    <div class="number"><span class="bold">Колличество:</span> <input type="text" id="count" value="1" name="count"/> шт.</div>
                    <div class="size"><span class="bold">Объём:</span>
                    	<ul id="size_price">
                        	<xsl:apply-templates select="size_price/item" />
                        </ul>
                    </div>
                    <div class="present">
                    	<input type="checkbox" value="1" id="present" name="present" />В подарочной упаковке <span style="white-space:nowrap;">подарок( +200 Р )</span>
                    </div>
                    <div class="order">
                    	<input type="hidden" name="item_id" value="{id}" id="item_id"  />
	                    <input type="button" id="order" value="Заказать" name="buy" />
                    </div>   
                    </form> 
                </div>
                
                <div class="tech_info">
                    <div class="item">Страна: <xsl:value-of select="country" /></div>
                    <div class="item">Вид упаковки: <xsl:value-of select="packing" /></div>
                </div>
                <xsl:if test="is_bio = 1">
                    <div class="sertificat">
                        <img src="public/images/sertificat.jpg" alt="Сертификат" />
                    </div>
                </xsl:if>
           </div>
           <div class="clear"></div>
        </div>
    </xsl:template>

    <xsl:template match="size_price/item"> 
        <li>
        <input type="radio" value="{price}" name="size" rel="{old_price}" alt="{size}" >
        	<xsl:if test="position() = 1">
            	<xsl:attribute name="checked">checked</xsl:attribute>
            </xsl:if>
        </input> 
        <xsl:value-of select="size" /></li>
    </xsl:template>



</xsl:stylesheet>