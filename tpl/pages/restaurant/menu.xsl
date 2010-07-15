<?xml version="1.0" encoding="UTF-8"?>
<!-- Страница информации о ресторане -->
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

    <!-- Импорт макета -->
    <xsl:include href="../../layouts/pages.xsl" />
    <xsl:template match="/">
        <xsl:apply-templates select="root" />
    </xsl:template >

    <!-- Код страницы -->
    <xsl:template match="content">
        <script type="text/javascript">
            calс_activate = true;
        </script>
        <div id="restaurant">
            <div class="restaurant_header rounded">
                <!-- Ссылка на предыдущий ресторан -->
                <a>
                    <xsl:choose>
                        <xsl:when test="//content/navigate/prev/id!=''">
                            <xsl:attribute name="href">
                                <xsl:text>/</xsl:text>
                                <xsl:value-of select="//site/city" />
                                <xsl:text>/restaurant/</xsl:text>
                                <xsl:value-of select="//content/navigate/prev/id" />
                                <xsl:text>-</xsl:text>
                                <xsl:value-of select="//content/navigate/mood" />
                                <xsl:text>-</xsl:text>
                                <xsl:value-of select="//content/navigate/offset+1-2" />
                            </xsl:attribute>
                        </xsl:when>
                    </xsl:choose>
                    <div class="back"></div>
                </a>
                <div class="caption">
                    <div class="title">
                        <xsl:call-template name="rest_link">
                            <xsl:with-param name="id" select="restaurant/id" />
                            <xsl:with-param name="uri" select="restaurant/rest_uri" />
                            <xsl:with-param name="title" select="restaurant/rest_title" />
                        </xsl:call-template>
                    </div>
                </div>
                <!-- Ссылка на следующий ресторан -->
                <a>
                    <xsl:choose>
                        <xsl:when test="//content/navigate/next/id!=''">
                            <xsl:attribute name="href">
                                <xsl:text>/</xsl:text>
                                <xsl:value-of select="//site/city" />
                                <xsl:text>/restaurant/</xsl:text>
                                <xsl:value-of select="//content/navigate/next/rest_id" />
                                <xsl:text>-</xsl:text>
                                <xsl:value-of select="//content/navigate/mood" />
                                <xsl:text>-</xsl:text>
                                <xsl:value-of select="//content/navigate/offset+1" />
                            </xsl:attribute>
                        </xsl:when>
                    </xsl:choose>
                    <div class="next"></div>
                </a>
                <div class="rest_rating">
                    <div class="minus"></div>
                    <div class="rating_line"><xsl:value-of select="restaurant/rest_rating" /></div>
                    <div class="plus"></div>
                </div>
            </div>
            <div class="restaurant_tags widthAuto">
                <xsl:apply-templates select="restaurant/tags/item" />
            </div>
            <div class="clear"></div>
            <div class="clear marginTop20px"></div>
            <!-- Вывод  информации по ресторану -->
            <div id="restaurant_menu">
                <!-- Левая колонка -->
                <div class="left_col">
                    <div class="menu_info">
                        <div class="logo box_shadow">
                            <xsl:choose>
                                <xsl:when test="restaurant/rest_logo=''">
                                    <img src="/public/images/icons/rest_logo_icon.jpg" />
                                </xsl:when>
                                <xsl:otherwise>
                                    <img src="/upload/image/rest_logo/{restaurant/rest_uri}.jpg" />
                                </xsl:otherwise>
                            </xsl:choose>
                        </div>
                        <div class="text">
                            <span>Кухня: </span> <xsl:value-of select="restaurant/cooks" /><br />
                            <span>Средняя сумма счета: </span> <xsl:value-of select="restaurant/check" /> р.<br />
                            <span>Меню обновлено недавно</span> <br />
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="menu_list">
                        <xsl:apply-templates select="//menu_list/item" />
                    </div>
                </div>
                <!-- Правая колонка -->
                <div class="right_col">
                    <div class="links">
                        <div class="rounded border_1px_6e6e6e padding10">
                            <ul>
                                <li class="link discount_icon"><a href="#">Получить скидку</a></li>
                                <li class="link dostavka_icon"><a href="#">Доставить еду</a></li>
                                <xsl:if test="rest_reserv_phone != ''">
                                <li class="link">
                                    <a href="#" id="reserv">Забронировать столик</a>
                                </li>
                                </xsl:if>
                                <li class="link"><a href="#">Заказать банкет</a></li>
                            </ul>
                            <div class="menu_link menu_icon">
                                Меню пожалуйста!
                                <xsl:if test="restaurant/have_menu_map=1">
                                    <ul class="sub_menu_link">
                                        <li class="bar_icon">
                                            <a>
                                                <xsl:attribute name="href">
                                                    <xsl:text>/</xsl:text>
                                                    <xsl:value-of select="//site/city" />
                                                    <xsl:text>/menu/map/</xsl:text>
                                                    <xsl:choose>
                                                        <xsl:when test="restaurant/rest_uri!=''">
                                                            <xsl:value-of select="restaurant/rest_uri" />
                                                        </xsl:when>
                                                        <xsl:when test="restaurant/rest_uri=''">
                                                            <xsl:value-of select="restaurant/id" />
                                                        </xsl:when>
                                                    </xsl:choose>
                                                </xsl:attribute>
                                                <xsl:text>Карта бара</xsl:text>
                                            </a>
                                        </li>
                                    </ul>
                                </xsl:if>
                            </div>
                        </div>
                    </div>
                    <div class="trash">
                        <div class="caption">Ваш счет</div>
                        <div class="items">
                            <table id="list_trash">
                                <tr>
                                    <th class="title">Наименование</th>
                                    <th class="count">Кол-во</th>
                                    <th class="price">Цена, р</th>
                                </tr>
                                <tr>
                                    <td colspan="3" class="top"></td>
                                </tr>

                            </table>
                            <table id="itogo">
                                <tr>
                                    <td colspan="3" class="bottom"></td>
                                </tr>
                                <tr>
                                    <td class='title'>Итого</td>
                                    <td></td>
                                    <td id="priceItogo" class="price">0</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </xsl:template >

    <xsl:template match="menu_list/item">
        <div class="menu_list">
            <div class="item_of_type">
                <div class="caption"><xsl:value-of select="title" /></div>
                <table>
                    <tr class="header">
                        <th>Название</th>
                        <th class="alignCenter">Порции, грамм</th>
                        <th class="price rounded_right alignCenter">Цена</th>
                    </tr>
                    <xsl:apply-templates select="dish/item" />
                </table>
            </div>
        </div>
    </xsl:template>

    <xsl:template match="dish/item">
        <tr id="dish_{dish_id}" class="dish_item">
            <td class="title"><xsl:value-of select="menu_title" disable-output-escaping="yes" /></td>
            <td class="portion"><xsl:value-of select="portion" /></td>
            <td class="price">
                <span><xsl:value-of select="price" /></span>
                <xsl:text> р.</xsl:text>
                <div class="img"><img class="add_trash_item" src="/public/images/icons/add_icon.png" /></div>
            </td>
        </tr>
        <tr rel="dish_{dish_id}" class="dish_item_l">
            <td class="description">
                <xsl:value-of select="description" disable-output-escaping="yes" />
            </td>
            <td></td>
            <td><div class="img"><img class="remove_trash_item" src="/public/images/icons/remove_icon.png" /></div></td>
        </tr>
    </xsl:template>

    <!-- Список тэгов -->
    <xsl:template match="restaurant/tags/item">
        <div class="item rounded">
            <div class="img" style="background-position:-{(position()-1)*32}px 0;" alt="{title}"></div>
            <div class="text"><xsl:value-of select="title" /></div>
        </div>
    </xsl:template>

</xsl:stylesheet>