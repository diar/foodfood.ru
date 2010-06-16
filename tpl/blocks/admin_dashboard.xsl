<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

    <xsl:template match="/">
        <div id="latest_foto" class="dashbord_block">
            <div class="dashbord_block_header">
                Фотография <a class="white" href="admin.php?page=restaurants&amp;action=edit">изменить</a>
            </div>
            <div class="dashbord_block_content">
                <xsl:choose>
                    <xsl:when test="//photo!=''">
                        <img src="/upload/image/rest_photo/{//restaurant/id}/{//photo//src}" alt="{rest_title}" />
                    </xsl:when>
                    <xsl:when test="//restaurant/rest_photo=0">
                        <img src="/public/images/rest_icon.jpg" style="padding:20px 40px;" alt="{rest_title}" />
                    </xsl:when>
                    <xsl:when test="//restaurant/rest_photo=1">
                        <img src="/upload/image/restaurant/{//restaurant/rest_uri}.jpg"  style="padding:0 90px;" alt="{rest_title}" />
                    </xsl:when>
                </xsl:choose>
                <div class="clear"></div>
            </div>
        </div>

        <div id="latest_sale" class="dashbord_block">
            <div class="dashbord_block_header">
                Последние <a class="white" href="admin.php?page=discountLog">скидки</a>
            </div>
            <div class="dashbord_block_content">
                <div class="dashbord_block_sale">
                    <xsl:apply-templates select="root/discounts/item" />
                </div>
            </div>
        </div>

        <div id="latest_afisha" class="dashbord_block">
            <div class="dashbord_block_header">
                Не пропустите
            </div>
            <div class="dashbord_block_content">
                <div class="dashbord_block_afisha">
                    <table>
                        <xsl:apply-templates select="root/posters/item" />
                    </table>
                </div>
            </div>
        </div>
        <div id="latest_reviews" class="dashbord_block">
            <div class="dashbord_block_header">
                Последние <a class="white" href="admin.php?page=reviews">отзывы</a>
            </div>
            <div class="dashbord_block_content">
                <div class="dashbord_block_reviews">
                    <xsl:apply-templates select="root/reviews/item" />
                </div>
            </div>
        </div>
    </xsl:template>

    <xsl:template match="photos/item">
        <div class="dashbord_block_foto">
            <img src="{../../web_dir}{src}" />
        </div>
    </xsl:template>

    <xsl:template match="discounts/item">
        <div class="dashbord_block_sale_item">
            <table>
                <tr>
                    <td class="dashbord_block_sale_number"><xsl:value-of select="phone" /></td>
                    <td class="dashbord_block_sale_percent"> 10 %</td>
                    <td class="dashbord_block_sale_date"><xsl:value-of select="send_date" /></td>
                </tr>
            </table>
        </div>
    </xsl:template>

    <xsl:template match="reviews/item">
        <div class="dashbord_block_sale_item">
            <div><xsl:value-of select="text" /></div>
        </div>
    </xsl:template>

    <xsl:template match="posters/item">
        <tr>
            <td class="dashbord_block_afisha_date">19 апреля</td>
            <td class="dashbord_block_afisha_text"><div>Открытие портала фудфуд Открытие портала фудфуд</div></td>
        </tr>
    </xsl:template>

</xsl:stylesheet>
