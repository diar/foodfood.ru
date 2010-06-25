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
        <!-- Дополнительная информация -->
        <table id="additional">
            <tr id="recomended">
                <td colspan="2" class="additional_left">
                    <div id="recomended_title" class="rounded_right"><div class="text">Стоит попробовать</div>
                        <div id="arrows">
                            <div class="back"></div>
                            <div class="next"></div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div id="recomended_container">
                        <div id="recomended_gallery">
                            <!-- Список рекомендуемых ресторанов и блюд -->
                            <xsl:apply-templates select="recomended/item" />
                        </div>
                    </div>
                </td>
                <td class="additional_right">
                    <!-- Баннер -->
                    <xsl:apply-templates select="recomended/banner" />
                </td>
            </tr>
            <tr>
                <td class="additional_hide_bar" colspan="3">
                    <img id="additional1" src="/public/images/icons/hide_additional.jpg" alt="hide" />
                </td>
            </tr>
            <tr class="additional_content" id="additional1_content">
                <td class="additional_left" id="restaurant_new">
                    <!-- Новый ресторан -->
                    <div class="caption rounded_right" >Новое место!</div>
                    <div class="ribbon">
                        <div class="box_for_shadow box_shadow_not_ie">
                            <div class="border">
                                <a class="container">
                                    <!-- Begin Создаем ссылку в зависимости от того, есть ли uri -->
                                    <xsl:attribute name="href">
                                        <xsl:text>/</xsl:text>
                                        <xsl:value-of select="//site/city" />
                                        <xsl:text>/restaurant/</xsl:text>
                                        <xsl:choose>
                                            <xsl:when test="new_rest/rest_uri!=''">
                                                <xsl:value-of select="new_rest/rest_uri" />
                                            </xsl:when>
                                            <xsl:when test="new_rest/rest_uri=''">
                                                <xsl:value-of select="new_rest/id" />
                                            </xsl:when>
                                        </xsl:choose>
                                    </xsl:attribute>
                                    <!-- End Создаем ссылку в зависимости от того, есть ли uri -->
                                    <xsl:choose>
                                        <xsl:when test="new_rest/rest_photo=0">
                                            <img src="/public/images/rest_icon.jpg" alt="{rest_title}" />
                                        </xsl:when>
                                        <xsl:when test="new_rest/rest_photo=1">
                                            <img src="/upload/image/restaurant/{new_rest/rest_uri}.jpg" alt="{rest_title}" />
                                        </xsl:when>
                                    </xsl:choose>
                                </a>
                            </div>
                            <div class="opened">
                            	<a>
                                	<xsl:attribute name="href">
                                        <xsl:text>/</xsl:text>
                                        <xsl:value-of select="//site/city" />
                                        <xsl:text>/restaurant/</xsl:text>
                                        <xsl:choose>
                                            <xsl:when test="new_rest/rest_uri!=''">
                                                <xsl:value-of select="new_rest/rest_uri" />
                                            </xsl:when>
                                            <xsl:when test="new_rest/rest_uri=''">
                                                <xsl:value-of select="new_rest/id" />
                                            </xsl:when>
                                        </xsl:choose>
                                    </xsl:attribute>
                            <xsl:value-of select="new_rest/rest_title" />
                            	</a>
                            </div>
                        </div>

                    </div>
                </td>
                <td class="additional_center" id="restaurant_poster">
                    <!-- Афиша ресторанов -->
                    <div class="caption rounded">
                        Афиша на неделю
                    </div>
                    <div id="posters">
                        <xsl:apply-templates select="posters/item" />
                    </div>
                    <div class="clear"></div>
                    <div class="more">Ещё есть <a href="/{//site/city}/poster">много мероприятий</a></div>
                </td>
                <td class="additional_right" id="restaurant_discount">
                    <!-- Горячие скидки -->
                    <div class="caption rounded_left">Cкидки</div>
                    <div class="clear"></div>
                    <div class="discounts">
                        <div class="clear"></div>
                        <xsl:apply-templates select="discounts/item" />
                        <div class="clear"></div>
                        <div class="more"><a href="/{//site/city}/discount">Все скидки</a></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="additional_hide_bar" colspan="3">
                    <img id="additional2" src="/public/images/icons/hide_additional.jpg" alt="hide" />
                </td>
            </tr>
            <tr class="additional_content" id="additional2_content">
                <td class="additional_left" id="restaurant_review">
                    <!-- Последние отзывы о ресторанах -->
                    <div class="caption rounded">Отзывы</div>

                    <xsl:choose>
                        <xsl:when test="count(reviews/item)>0" >
                            <xsl:apply-templates select="reviews/item" />
                        </xsl:when>
                        <xsl:otherwise>
                            <div style="margin-top:15px;margin-left:20px;">Пока никто не оставлял отзывов...</div>
                        </xsl:otherwise>
                    </xsl:choose>
                </td>
                <td class="additional_center" id="restaurant_article">
                    <!-- Статьи -->
                    <div class="caption rounded"><a href="/blog/restaurant/foodfood/">За чашкой кофе</a></div>
                    <xsl:apply-templates select="articles/item" />
                </td>
                <td class="additional_right" id="restaurant_dostavka">
                    <div class="caption rounded_left"><a href="#">On-line заказы</a></div>
                    <div class="clear"></div>
                    <ul>
                        <xsl:call-template name="dostavka" />
                    </ul>
                </td>
            </tr>
        </table>
    </xsl:template >

    <!-- Список рекомендуемых ресторанов -->
    <xsl:template match="recomended/item">
        <div class="item" rel="{id}">
            <div class="img">
                <a class="container">
                    <!-- Begin Создаем ссылку в зависимости от того, есть ли uri -->
                    <xsl:attribute name="href">
                        <xsl:text>/</xsl:text>
                        <xsl:value-of select="//site/city" />
                        <xsl:text>/restaurant/</xsl:text>
                        <xsl:choose>
                            <xsl:when test="rest_uri!=''">
                                <xsl:value-of select="rest_uri" />
                            </xsl:when>
                            <xsl:when test="rest_uri=''">
                                <xsl:value-of select="id" />
                            </xsl:when>
                        </xsl:choose>
                        <xsl:text>-rating-</xsl:text>
                        <xsl:value-of select="position()" />
                    </xsl:attribute>
                    <!-- End Создаем ссылку в зависимости от того, есть ли uri -->
                    <xsl:choose>
                        <xsl:when test="rest_photo=0">
                            <img src="/public/images/rest_icon.jpg"  alt="{rest_title}" class="rest_image" />
                        </xsl:when>
                        <xsl:when test="rest_photo=1">
                            <img src="/upload/image/restaurant/{rest_uri}.jpg"  alt="{rest_title}" class="rest_image" />
                        </xsl:when>
                    </xsl:choose>
                </a>
                <div class="rest_rating">
                    <div class="minus"></div>
                    <div class="rating_line">
                    	<div class="rating_complete" style="width:{rating_complete}%"></div>
                    <xsl:value-of select="rest_rating" /></div>
                    <div class="plus"></div>
                </div>
            </div>
            <div class="description">
                <div class="name">
                    <a>
                        <xsl:attribute name="href">
                            <xsl:text>/</xsl:text>
                            <xsl:value-of select="//site/city" />
                            <xsl:text>/restaurant/</xsl:text>
                            <xsl:choose>
                                <xsl:when test="rest_uri!=''">
                                    <xsl:value-of select="rest_uri" />
                                </xsl:when>
                                <xsl:when test="rest_uri=''">
                                    <xsl:value-of select="id" />
                                </xsl:when>
                            </xsl:choose>
                            <xsl:text>-rating-</xsl:text>
                            <xsl:value-of select="position()" />
                        </xsl:attribute>
                        <xsl:value-of select="rest_title" />
                    </a>
                </div>
                <div class="commentCount">
                    <a>
                        <xsl:attribute name="href">
                            <xsl:text>/</xsl:text>
                            <xsl:value-of select="//site/city" />
                            <xsl:text>/restaurant/</xsl:text>
                            <xsl:choose>
                                <xsl:when test="rest_uri!=''">
                                    <xsl:value-of select="rest_uri" />
                                </xsl:when>
                                <xsl:when test="rest_uri=''">
                                    <xsl:value-of select="id" />
                                </xsl:when>
                            </xsl:choose>
                            <xsl:text>-rating-</xsl:text>
                            <xsl:value-of select="position()" />
                        </xsl:attribute>
                        <xsl:value-of select="rest_comment_count" />
                    </a>
                </div>
            </div>
        </div>
    </xsl:template>

    <!-- Список блоков афиши -->
    <xsl:template match="posters/item">
        <div class="poster_block">
            <xsl:apply-templates select="item" />
        </div>
    </xsl:template>

    <!-- Список элементов афиши -->
    <xsl:template match="posters/item/item">
        <div class="poster">
            <xsl:choose>
                <xsl:when test="img=''">
                    <img class="poster_icon box_shadow box_shadow_not_ie" src="/public/images/poster_icon.jpg" alt="{title}" />
                </xsl:when>
                <xsl:otherwise>
                    <img class="poster_icon box_shadow box_shadow_not_ie" src="/upload/image/poster/{img}" alt="{title}" />
                </xsl:otherwise>
            </xsl:choose>
            <div class="poster_text">
                <xsl:call-template name="rest_link">
                    <xsl:with-param name="id" select="rest_id" />
                    <xsl:with-param name="uri" select="rest_uri" />
                    <xsl:with-param name="title" select="rest_title" />
                    <xsl:with-param name="class">rest_caption</xsl:with-param>
                </xsl:call-template>
                <a class="poster_title" href="/{//site/city}/poster/view/{rest_poster_id}">
                    <xsl:value-of select="title" />
                </a>
                <div class="text"><xsl:value-of select="anounce" /></div>
            </div>
        </div>
        <div class="clear"></div>
    </xsl:template>

    <!-- Список скидок -->
    <xsl:template match="discounts/item">
        <div class="discount" partner="{rest_id}" >
            <div class="count rounded">
                <xsl:if test="16 &lt; discount_percent">
                    <xsl:attribute name="class">count rounded sale20</xsl:attribute>
                </xsl:if>
                <xsl:if test="16 &gt; discount_percent">
                    <xsl:attribute name="class">count rounded sale15</xsl:attribute>
                </xsl:if>
                <xsl:if test="6 &gt; discount_percent ">
                    <xsl:attribute name="class">count rounded sale5</xsl:attribute>
                </xsl:if>
                <span class="percent"><xsl:value-of select="discount_percent" /> %</span>
            </div>
            <div class="description"><xsl:value-of select="discount_description" disable-output-escaping="yes" /></div>
            <div class="rest_caption">
                <xsl:call-template name="rest_link">
                    <xsl:with-param name="id" select="rest_id" />
                    <xsl:with-param name="uri" select="rest_uri" />
                    <xsl:with-param name="title" select="rest_title" />
                </xsl:call-template>
                <div class="left">Осталось: <xsl:value-of select="discount_count" /></div>
            </div>
        </div>
    </xsl:template>

    <!-- Список отзывов -->
    <xsl:template match="reviews/item">
        <div class="review">
            <div class="from">
                <a href="/blog/profile/{user_login}" class="user"><xsl:value-of select="user_login" /></a>
                говорит о «
                <xsl:call-template name="rest_link">
                    <xsl:with-param name="id" select="rest_id" />
                    <xsl:with-param name="uri" select="rest_uri" />
                    <xsl:with-param name="title" select="rest_title" />
                </xsl:call-template>
                »:
            </div>
            <div class="text">
                <span class="lq">«</span><xsl:value-of select="text" /><span class="rq">»</span>
            </div>
        </div>
    </xsl:template>

    <!-- Список блоков интересных статей -->
    <xsl:template match="articles/item">
        <div class="article_block">
            <xsl:apply-templates select="item" />
        </div>
    </xsl:template>

    <!-- Список интересных статей -->
    <xsl:template match="articles/item/item">
        <div class="article">
            <div class="date">
                <div>
                    <div class="number"><xsl:value-of select="topic_date_day" /></div>
                    <div class="month"><xsl:value-of select="topic_date_month" /></div>
                </div>
            </div>
            <div class="article_text">
                <a class="article_title" href="/blog/restaurant/foodfood/{topic_id}.html">
                    <xsl:value-of select="title" />
                </a>
                <div class="text"><xsl:value-of select="text" disable-output-escaping="yes" /></div>
                <div class="article_description">
                    <a href="/blog/restaurant/foodfood/{topic_id}.html">
                        <xsl:value-of select="comment_count" />
                    </a>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </xsl:template>

    <!-- Список Доставки -->
    <xsl:template name="dostavka">
        <li class="dostavka_li"><span>15.07</span><a href="">Суши Маки</a></li>
    </xsl:template>

</xsl:stylesheet>