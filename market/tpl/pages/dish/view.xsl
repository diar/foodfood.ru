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
        <script type="text/javascript">
            dish_page_activate = true;
        </script>
        <xsl:apply-templates select="dish" />
    </xsl:template >

    <!-- Информация о ресторане -->
    <xsl:template match="dish">
        <div id="dish">
            <div class="dish_header rounded">
                <!-- Ссылка на предыдущий ресторан -->
                <div style="margin:0 auto; max-width:1600px;" class="caption">
                    <h1 class="title">
                        <xsl:value-of select="title" />
                    </h1>
                </div>
            </div>
         </div>
         <table id="main_table">
            <tr>
                <td class="menu_col" width="16%">
                    <div class="menu">
                        <h3>Категории</h3>
                        <ul id="menu_types">
                                <xsl:apply-templates select="menu_types/item" />
                        </ul>
                        <xsl:if test="count(rest_menu/item)>1">
                            <h3>Рестораны</h3>
                            <ul id="rest_menu">
                                <xsl:apply-templates select="rest_menu/item" />
                            </ul>
                        </xsl:if>
                    </div>
                </td>
                <td class="dish_col" width="51%">
                   <div class="clear"></div>
            <!-- Вывод  информации по ресторану -->
            <div id="dish_info">
                <!-- Левая колонка -->
                
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
                
                <!-- Средняя колонка -->
                
                    <div class="description">
                           <div class="text"><xsl:value-of select="description" /></div>
                    </div>
                        
                    <div class="clear"></div>
                    <div class="dish_reviews">
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

                </td>
                <td width="33%" class="price_col">
                        <div class="price_col">
                            <xsl:choose>
                              <xsl:when test="count(portion/item) = 1">
                                <div id="portions">
                                    <div class="name" style="float:left;">Порция:</div>
                                    <div class="text" style="float:left;padding-left:10px;"><xsl:value-of select="portion" /></div>
                                </div>
                                <div class="clear"></div>
                                <div id="price">
                                    <div class="name">Цена:</div>
                                    <div class="text"><span id="price_text"><xsl:value-of select="price" /></span> руб.</div>
                                </div>
                              </xsl:when>
                              <xsl:otherwise>
                                <div id="portions">
                                    <div class="name">Порция</div>
                                    <div class="text"><xsl:apply-templates select="portion/item" /></div>
                                </div>
                                <div id="price">
                                    <div class="name">Цена:</div>
                                    <div class="text"><span id="price_text"><xsl:value-of select="price" /></span> руб.</div>
                                </div>
                              </xsl:otherwise>
                            </xsl:choose>
                            <div class="clear"></div>
                            <xsl:if test="calories != ''">
                            <div class="des_item">
                                <div class="name">кКал:</div>
                                <div class="text"><xsl:value-of select="calories" /></div>
                            </div>
                            </xsl:if>
                            <div class="clear"></div>
                            <div class="hidden">
                                <div id="to_trash_dish_id"><xsl:value-of select="market_menu_id" /></div>
                                <div id="to_trash_portion"><xsl:value-of select="portion" /></div>
                                <div id="to_trash_rest_id"><xsl:value-of select="rest_id" /></div>
                            </div>
                            <div class="text"><input type="button" value="В корзину" id="to_trash" /></div>

                            <div class="dostavka_info">
                                Доставка заказа от 500 руб. — бесплатно. <br />
                                При заказе до 500 руб. стоимость  доставки составляет 90 руб.
                            </div>
                        </div>
                </td>

            </tr>
        </table>
            
  
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
                <a href="/upload/image/market_photo/{../../id}/{src}">
                    <img src="/upload/image/market_photo/{../../id}/{src}"
                         class="main" alt="{rest_title}" />
                </a>
            </xsl:when>
            <xsl:when test="$big=0">
                <img src="/upload/image/market_photo/{../../id}/mini-{src}"
                     rel="/upload/image/market_photo/{../../id}/{src}" class="mini" />
            </xsl:when>
        </xsl:choose>
    </xsl:template>
    
    <xsl:template match="menu_types/item">
        <li id="{id}"><a href="#" ><xsl:value-of select="title" /></a></li>
    </xsl:template>

    <xsl:template match="rest_menu/item">
        <li><a href="#" rel="{id}"><xsl:value-of select="rest_title"  /></a></li>
    </xsl:template>

    <xsl:template match="portion/item">
        <xsl:param name="pos" select="position()" />
        <div class="portion"><input type="radio" name="portion" value="{.}" rel="{../../price/item[$pos]}" >
            <xsl:if test="$pos = 1">
                <xsl:attribute name="checked" value="checked" />
            </xsl:if>
        </input><xsl:value-of select="."  /> (<xsl:value-of select="../../second_portion/item[$pos]"  />)</div>
    </xsl:template>


</xsl:stylesheet>