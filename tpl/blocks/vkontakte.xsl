<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

    <xsl:template match="/">
        <xsl:apply-templates select="root" />
    </xsl:template >


    <xsl:template match="root">
        <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
            <head>
                <title><xsl:value-of select="site/title" /></title>
                <meta name="keywords" content="{site/keywords}" />
                <link rel="icon" type="image/vnd.microsoft.icon"  href="/public/images/favicon.ico" />
                <link rel="stylesheet" type="text/css" href="/public/css/discount.css" />
            </head>
            <body id="discount_body">
                <xsl:apply-templates select="content" />
                <div id="discount_message" class="dialog">
                    <div class="dialog_caption">
                        <div class="dialog_caption_text">FoodFood.ru</div>
                        <a href="#" class="dialog_caption_close" id="discount_message_close">закрыть</a>
                    </div><div class="clear"></div>
                    <div id="discount_message_window" class="dialog_window"></div>
                </div>
                <div id="discount_message_border" class="dialog_border" />
                <img id="discount_loader" src="/public/images/loader.gif" />
                <script type="text/javascript" src="http://www.google.com/jsapi"></script>
                <script type="text/javascript">
                    google.load("jquery", "1.4.2");
                    site_city = '<xsl:value-of select="site/city" />';
                    partner_id = '<xsl:value-of select="content/partner/rest_id" />';
                </script>
                <script type="text/javascript" src="/public/js/libs/jquery.corner.js"></script>
                <script src="http://vkontakte.ru/js/api/xd_connection.js" type="text/javascript"></script>
                <script type="text/javascript" src="/public/js/vkontakte.js"></script>
            </body>
        </html>
    </xsl:template>

    <xsl:template match="content">
        <div id="discount_content" style="padding-left:10px;">
            <div id="discount_center">
                <div id="window_discount" class="discount_window corner">
                    <div style="padding:20px 25px;">
                        <div class="count">
                            осталось
                            <div class="counter corner">
                                <xsl:value-of select="partner/discount_count" />
                            </div>
                            скидки
                        </div>
                        <h1 class="caption">Получи скидку <xsl:value-of select="partner/discount_percent" />%</h1>
                        <h1 class="caption mini">
                            <span id="selectMenu">
                                <a href="/{//site/city}/vk/{partner/rest_uri}" id="currentOption">в <xsl:value-of select="partner/discount_title" /></a>
                                <div id="options" class="corner_bottom">
                                    <xsl:apply-templates select="restaurants/item" />
                                </div>
                            </span>
                        </h1>
                        <input id="discount_name" class="discount_input corner" type="text" value="{user_name}" />
                        <input id="discount_phone" class="discount_input corner" type="text" value="моб. телефон" />
                        <input id="discount_email" class="discount_input corner" type="text" value="e-mail" />
                        <img class="discount_fish" src="/public/images/discount_fish.jpg" alt="fish" />
                        <input id="discount_submit" class="discount_button corner" type="button" value="Скидка" />
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <div id="discount_right">
                <div id="discount_lcur"></div>
                <div id="discount_tip">
                    <div style="padding:20px;">
                        <h1 class="caption">БЕСПЛАТНО!</h1>
                        <p>
                            Вам придёт SMS с содержанием: название ресторана, процент,
                            скидки, дата получения скидки и именем отправителя foodfood.ru
                        </p><p>
                            Предъявляя SMS в ресторане вы получаете скидку, а ресторан
                            анализирует трафик с ресторанного портала foodfood.ru.
                        </p><p style="padding:0">
                            Скидка действительна в течение двух дней.
                        </p><p class="min">
                            Вся информация конфиденциальна и не передается третьим лицам.<br />
                            Для справок: (843) 5700 919
                        </p>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div style="font-size:32px;margin-top:30px;">
                <a href="http://foodfood.ru" style="color:black">www.foodfood.ru:</a>
                Осталось <xsl:value-of select="//left" /> дней до открытия
            </div>
        </div>
    </xsl:template >

    <!-- Список ресторанов, предоставляющих скидки -->
    <xsl:template match="restaurants/item">
        <xsl:param name="partner_id" select="../../partner/id" />
        <xsl:choose>
            <xsl:when test="$partner_id!=rest_id">
                <div class="option">
                    <a href="/{//site/city}/vk/{rest_uri}?user_name={//content/user_name}">
                        в <xsl:value-of select="discount_title" /></a>
                </div>
            </xsl:when>
        </xsl:choose>
    </xsl:template>

</xsl:stylesheet>
