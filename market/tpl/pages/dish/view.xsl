<?xml version="1.0" encoding="UTF-8"?>
<!-- Страница информации о ресторане -->
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
        <xsl:apply-templates select="dish" />
    </xsl:template >

    <!-- Информация о ресторане -->
    <xsl:template match="dish">
        <div id="dish">
            <div class="dish_header rounded">
                <!-- Ссылка на предыдущий ресторан -->
                <div style="margin:0 auto; max-width:1600px;">
                    <a href="#">
                        <div class="back"></div>
                    </a>
                    <div>
                        <div class="caption">
                            <h1 class="title">
                                <xsl:value-of select="title" />
                            </h1>
                        </div>
                        <a href="#">
                            <div class="next"></div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="clear marginTop20px"></div>
            <!-- Вывод  информации по ресторану -->
            <div id="restaurant_info">
                <!-- Левая колонка -->
                <div class="left_col">
                    <div class="photos">
                        <div class="main_container">
                            <xsl:choose>
                                <xsl:when test="photos=''">
                                    <img src="/public/images/rest_icon_big.jpg" class="main" alt="{rest_title}" />
                                </xsl:when>
                                <xsl:otherwise>
                                    <xsl:apply-templates select="photos/item">
                                        <xsl:with-param name="big">1</xsl:with-param>
                                    </xsl:apply-templates>
                                </xsl:otherwise>
                            </xsl:choose>
                        </div>
                        <div>
                            <xsl:if test="photos=''">
                                <img src="/public/images/rest_icon_big.jpg" class="mini" alt="{rest_title}" />
                            </xsl:if>
                            <xsl:apply-templates select="photos/item">
                                <xsl:with-param name="big">0</xsl:with-param>
                            </xsl:apply-templates>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <!-- Средняя колонка -->
                <div class="center_col">
                    <div class="rest_reviews">
                        <div class="caption">Отзывы</div>
                        <div class="reviews">
                            <xsl:if test="count(reviews/item)=0">
                                <div style="padding:10px 0;">Ты можешь оставить отзыв первым!</div>
                            </xsl:if>
                            <xsl:apply-templates select="reviews/item" />
                            <div class="form">
                                <form action="" method="post">
                                    <textarea name="text" class="rounded" id="review_textarea"></textarea>
                                    <input type="submit" value="Отправить" />
                                    <div style="color:#999999;font-size:12px;padding-top:3px;">Символов:
                                        <span id="reviews_comment_lenght">0</span> из 2000
                                    </div>
                                    <div style="padding-top:10px;">
                                        <input type="checkbox" style="float:none;margin:0;height:14px;width:14px;" />
                                        <span>отправить ресторатору</span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </xsl:template>

    <!-- Список отзывов -->
    <xsl:template match="reviews/item">
        <div class="review">
            <div class="user">
                <a href="/blog/profile/{user_login}">
                    <xsl:value-of select="user_login" />
                </a>
                говорит:
            </div>
            <div class="text">«
                <xsl:value-of select="text" /> »
            </div>
        </div>
    </xsl:template>

    <!-- Список фотографий -->
    <xsl:template match="photos/item">
        <xsl:param name="big" />
        <xsl:choose>
            <xsl:when test="$big=1">
                <a href="http://uploads.foodfood.ru/image/rest_photo/{../../id}/{src}">
                    <img src="http://uploads.foodfood.ru/image/rest_photo/{../../id}/{src}"
                         class="main" alt="{rest_title}" />
                </a>
            </xsl:when>
            <xsl:when test="$big=0">
                <img src="http://uploads.foodfood.ru/image/rest_photo/{../../id}/mini-{src}"
                     rel="http://uploads.foodfood.ru/image/rest_photo/{../../id}/{src}" class="mini" />
            </xsl:when>
        </xsl:choose>
    </xsl:template>

</xsl:stylesheet>