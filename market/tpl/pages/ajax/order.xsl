<?xml version="1.0" encoding="UTF-8"?>
<!-- Страница для получения списка ресторанов по настроению через Ajax -->
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>
    <xsl:template match="/">
        <table id="dish_order_items">
            <tr>
                <td>Название</td>
                <td>Порция</td>
                <td>Количество</td>
                <td>Цена</td>
                <td></td>
            </tr>
            <xsl:apply-templates select="//trash/item/items/item" />
        </table>
        <div class="gen_price">Итого: <xsl:value-of select="//trash/price" /></div>
    </xsl:template>
    
    <xsl:template match="//trash/item/items/item">
        <tr class="item">
            <td><xsl:value-of select="../../title" /></td>
            <td class="portion"><xsl:value-of select="portion" /> гр</td>
            <td class="count"><xsl:value-of select="count" /></td>
            <td class="price"><xsl:value-of select="price" /></td>
            <td>
                <a href="#" class="remove_item">x</a>
            </td>
        </tr>
    </xsl:template>

</xsl:stylesheet>