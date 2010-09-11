<?xml version="1.0" encoding="UTF-8"?>
<!-- Страница для получения списка ресторанов по настроению через Ajax -->
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>
    <xsl:template match="/">
        <div style="padding:10px;padding-bottom:2px;">
            <table class="caption">
                <tr>
                    <td class="trash_title" style="width:40%">Название</td>
                    <td style="width:20%">Порция</td>
                    <td style="width:20%">Количество</td>
                    <td style="width:15%">Цена</td>
                    <td style="width:5%"></td>
                </tr>
            </table>
        </div>
        <div class="rounded">
            <table id="dish_order_items">
                <xsl:apply-templates select="//trash/item/items/item" />
            </table>
        </div>
        <table class="gen_price">
            <tr>
                <td style="text-align:right;">Доставка :</td>
                <td style="font-weight:normal;">
                            <xsl:choose>
                                <xsl:when test='//trash/price > 500'>
                                    Бесплатно
                                </xsl:when>
                                <xsl:otherwise>
                                    90 рублей
                                </xsl:otherwise>
                            </xsl:choose>
                </td>
            </tr>
            <tr>
                <td style="text-align:right;">Итого :</td>
                <td><xsl:value-of select="//trash/price" /> руб.</td>
            </tr>
        </table>
        <div class="clear"></div>
    </xsl:template>
    
    <xsl:template match="//trash/item/items/item">
        <tr class="trash_item" rel="{../../dish_id}">
            <xsl:if test="count(//trash/item/items/item)=position()">
                <xsl:attribute name="class">trash_item last</xsl:attribute>
            </xsl:if>
            <td style="width:40%" class="trash_title">
                <xsl:value-of select="../../title" />
            </td>
            <td style="width:20%" class="trash_portion">
                <xsl:value-of select="portion" /> гр
            </td>
            <td style="width:20%" class="trash_count">
                <div style="width:53px;margin:auto;">
                    <a href="#" class="minus_item"></a>
                    <span style="float:left;padding:0 3px;">
                        <xsl:value-of select="count" />
                    </span>
                    <a href="#" class="plus_item"></a>
                </div>
            </td>
            <td style="width:15%" class="trash_price">
                <xsl:value-of select="price" />
            </td>
            <td style="width:5%">
                <a href="#" class="remove_item"></a>
            </td>
        </tr>
    </xsl:template>

</xsl:stylesheet>