<?xml version="1.0" encoding="UTF-8"?>
<!-- Страница авторизации -->
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
        <div class="restaurant_header margin020 rounded">
            <div class="margin0autoMax-width1600">
                <div class="caption">
                    <div class="title">FoodFood объявляет конкурс! Пригласи всех своих друзей и поужинай за наш счет!
                    </div>
                </div>
            </div>
        </div>
        <div class="auth_page">
            <div id="registration_page" style="float:left;width:420px;">
                <div class="caption">
                    <div class="clear"></div>
                    <img class="form_loader" id="reg_loader" src="/public/images/loader.gif" alt="загрузка.." />
                    <div class="message" id="reg_message"></div>
                    <div id="registration_form" class="ajax_form form_dialog">
                        <div class="label">имя:</div>
                        <input type="text" class="form_input rounded" name="reg_name" id="reg_name" />
                        <div class="label">номер мобильного телефона:</div>
                        <input type="text" class="form_input rounded" name="reg_phone" id="reg_phone" />
                        <div class="label">e-mail:</div>
                        <input type="text" class="form_input rounded" name="reg_mail" id="reg_mail" />
                        <div class="label">Код-приглашения:</div>
                        <input type="text" class="form_input rounded" name="invite_code" id="invite_code" value='{invite_code}'/>
                        <div style="padding:15px 0">
                            <input type="checkbox" id="reg_rules" />
                            <span >ознакомлен с </span>
                            <a href="/{//site/city}/content/rules">правилами</a>
                        </div>
                        <input type="button" id="registration_submit" value="Я — гурман!" />
                    </div>
                    
                </div>
            </div>
            <div class="konkurs_description">
                <p>
                    Самым активным пользователям нашего портала, пригласившим на foodfood.ru больше всех друзей, мы дарим подарки:
                    <ul style="font-size:18px;margin:20px 0 20px 20px;">
                        <li>
                            <span class="number">1 место</span> — сертификат на ужин в ресторане на двоих
                        </li>
                        <li>
                            <span class="number">2 место</span> — сертификат на ужин в ресторане на одного
                        </li>
                        <li>
                            <span class="number">3 место</span> — футболка с фирменным логотипом foodfood.ru
                        </li>
                    </ul>
                </p>
                <xsl:if test="//user/user_id!=''">
                    <p>
                    Ваш ссылка, отправьте эту ссылку друзьям:
                        <div class="promo">
													<xsl:text>http://foodfood.ru/kazan/auth/pr</xsl:text>
													<xsl:value-of select="//user/user_id" />
												</div>
                    </p>
                </xsl:if>
								<p><a href="/{//site/city}/content/konkurs" style="font-size:16px;">Подробнее о конкурсе</a></p>
                <p>Потенциальные победители:</p>
                <p>
                    <table style="width:350px;">
                        <xsl:apply-templates select="invite_users/item" />
                    </table>
                </p>
            </div>
            <div class="clear"></div>
        </div>
    </xsl:template >


    <xsl:template match="invite_users/item">
        <tr>
            <td style="width:60px;">
                <xsl:choose>
                    <xsl:when test="user_profile_avatar!=''">
                        <img src="{user_profile_avatar}" style="width:48px;" />
                    </xsl:when>
                    <xsl:otherwise>
                        <img src="/blog/templates/skin/new/images/avatar_48x48.jpg" style="width:48px;" />
                    </xsl:otherwise>
                </xsl:choose>
            </td>
            <td>
                <a style="font-size:16px;" href="/blog/profile/{user_login}" ><xsl:value-of select="user_login" /></a>
            </td>
            <td style="font-family:Georgia; font-size:28px;color:#ff6600;">
                <xsl:value-of select="count" />
            </td>
        </tr>
    </xsl:template>
</xsl:stylesheet>
