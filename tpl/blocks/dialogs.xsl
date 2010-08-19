<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>
    <xsl:template name="auth_dialog">
        <div id="auth_dialog" class="dialog_box dialog box_shadow">
            <div class="caption">
                <img class="close_button" src="/public/images/icons/close_icon.jpg" alt="закрыть"></img>
                <div class="clear"></div>
                <img class="form_loader" id="auth_loader" src="/public/images/loader.gif" alt="загрузка.."></img>
                <div class="title">Войти на кухню</div>
                <div class="message" id="auth_message"></div>
                <div id="auth_form" class="ajax_form form_dialog">
                    <div class="label">e-mail (номер мобильного телефона):</div>
                    <input type="text" name="login" id="auth_login" class="form_input rounded" />
                    <div class="label">пароль:</div>
                    <input type="password" name="password" id="auth_password" class="form_input rounded" />
                    <span id="remain_me" >Помни меня</span>
                    <input id="remain_me_check" name="remember" type="checkbox" />
                    <div class="clear"></div>
                    <input type="button" id="auth_submit" value="Войти" />
                    <div style="margin-top:10px;">
                        <a href="#" onclick="$.toggleDialog('passwd_dialog');">Вспомнить пароль</a>
                    </div>
                </div>
            </div>
        </div>
    </xsl:template>

    <xsl:template name="passwd_dialog">
        <div id="passwd_dialog" class="dialog_box dialog box_shadow">
            <div class="caption">
                <img class="close_button" src="/public/images/icons/close_icon.jpg" alt="закрыть"></img>
                <div class="clear"></div>
                <img class="form_loader" id="passwd_loader" src="/public/images/loader.gif" alt="загрузка.."></img>
                <div class="title">Восстановить пароль</div>
                <div class="message" id="passwd_message"></div>
                <div id="passwd_form" class="ajax_form form_dialog">
                    <div class="label">e-mail (номер мобильного телефона):</div>
                    <input type="text" name="login" id="passwd_login" class="form_input rounded" />
                    <div class="clear"></div>
                    <input type="button" id="passwd_submit" value="Выслать пароль" />
                </div>
            </div>
        </div>
    </xsl:template>

    <xsl:template name="callback_dialog">
        <div id="callback_dialog" class="dialog_box dialog box_shadow">
            <div class="caption">
                <img class="close_button" src="/public/images/icons/close_icon.jpg" alt="закрыть"></img>
                <div class="clear"></div>
                <img class="form_loader" id="callback_loader" src="/public/images/loader.gif" alt="загрузка.."></img>
                <div class="title">Обратная связь</div>
                <div class="message" id="callback_message"></div>
                <div id="callback_form" class="ajax_form form_dialog">
                    <div class="label">ваш e-mail:</div>
                    <input type="text" name="mail" id="callback_mail" class="form_input rounded" />
                    <div class="label">сообщение:</div>
                    <textarea name="text" id="callback_text" class="form_input rounded"></textarea>
                    <div class="clear"></div>
                    <input type="button" id="callback_submit" value="Отправить" />
                </div>
            </div>
        </div>
    </xsl:template>

    <xsl:template name="reserving_dialog">
        <div id="reserving_dialog" class="dialog_box dialog box_shadow">
            <div class="caption">
                <img class="close_button" src="/public/images/icons/close_icon.jpg" alt="закрыть"></img>
                <div class="clear"></div>
                <img class="form_loader" id="reserving_loader" src="/public/images/loader.gif" alt="загрузка.."></img>
                <div class="title">Забронировать столик</div>
                <div class="message" id="reserving_message"></div>
                <div id="reserving_form" class="ajax_form form_dialog">
                    <div style="width:30%;float:left; margin-right:19px;">
                        <div class="label">Дата:</div>
                        <input type="text" name="date" id="reserving_date" class="form_input rounded" />
                    </div>
                    <div style="width:30%;float:left; margin-right:19px;">
                        <div class="label">Время:</div>
                        <input type="text" name="time" id="reserving_time" class="form_input rounded" />
                    </div>
                    <div style="width:30%;float:left;">
                        <div class="label">Количество человек:</div>
                        <input type="text" name="count" id="reserving_count" class="form_input rounded" />
                    </div>
                    <div class="clear"></div>
                    <div style="width:48%;float:left; margin-right:15px;">
                        <div class="label">Как Вас зовут?</div>
                        <input type="text" name="name" id="reserving_name" class="form_input rounded" />
                    </div>
                    <div style="width:48%;float:left;">
                        <div class="label">Контактный телефон:</div>
                        <input type="text" name="phone" id="reserving_phone" class="form_input rounded" value="+7"/>
                    </div>
                    <div class="clear"></div>
                    <div class="label">Коментарий:</div>
                    <textarea name="text" id="reserving_text" class="form_input rounded"></textarea>
                    <div class="clear"></div>
                    <input type="hidden" value="{//content/restaurant/id}" name="rest_id" id="reserving_rest_id"/>
                    <input type="button" id="reserving_submit" value="Отправить" />
                </div>
            </div>
        </div>
    </xsl:template>

    <xsl:template name="registration_dialog">
        <div id="registration_dialog" class="dialog_box dialog box_shadow">
            <div class="caption">
                <img class="close_button" src="/public/images/icons/close_icon.jpg" alt="закрыть" />
                <div class="clear"></div>
                <img class="form_loader" id="reg_loader" src="/public/images/loader.gif" alt="загрузка.." />
                <div class="title">Регистрация нового гурмана</div>
                <div class="message" id="reg_message"></div>
                <div id="registration_form" class="ajax_form form_dialog">
                    <div class="label">имя:</div>
                    <input type="text" class="form_input rounded" name="reg_name" id="reg_name" />
                    <div class="label">номер мобильного телефона:</div>
                    <input type="text" class="form_input rounded" name="reg_phone" id="reg_phone" />
                    <div class="label">e-mail:</div>
                    <input type="text" class="form_input rounded" name="reg_mail" id="reg_mail" />
                    <div style="padding:15px 0">
                        <input type="checkbox" id="reg_rules" />
                        <span >ознакомлен с </span>
                        <a href="/{//site/city}/content/rules">правилами</a>
                    </div>
                    <input type="button" id="registration_submit" value="Я — гурман!" />
                </div>
                <img src="/public/images/dorozhka.png" style="margin-top:-3px;" alt="дорожка" />
            </div>
        </div>
    </xsl:template>

    <xsl:template name="discount_dialog">
        <div id="discount_dialog" class="dialog_box dialog box_shadow">
            <div class="left">
                <div class="discount_percent">
                    <div class="number">15
                        <span>%</span>
                    </div>
                    <div>скидка</div>
                </div>
                <div class="description_discount">описание</div>
            </div>
            <div class="right">
                <div class="message" id="discount_message"></div>
                <img class="form_loader" style="margin-left:-60px;" id="discount_loader" src="/public/images/loader.gif" alt="загрузка.." />
                <div class="form">
                    <div class="inputs">
                        <div id="discount_form" class="ajax_form form_dialog">
                            <div class="label">имя:</div>
                            <input type="text" class="form_input rounded" value="{//user/user_login}"
                                   name="discount_name" id="discount_name" />
                            <div class="label">номер мобильного телефона:</div>
                            <input type="text" class="form_input rounded" value="{//user/user_phone}"
                                   name="discount_phone" id="discount_phone" />
                            <div class="label">e-mail:</div>
                            <input type="text" class="form_input rounded" value="{//user/user_mail}"
                                   name="discount_mail" id="discount_mail" />
                            <div style="text-align:center;height:20px;">
                                <xsl:choose>
                                    <xsl:when test="//user/user_login=''">
                                        <input type="checkbox" id="discount_reg" name="registration" />
                                        <span >зарегистрироваться</span>
                                    </xsl:when>
                                </xsl:choose>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <img class="close_button" src="/public/images/icons/close_icon.jpg" alt="закрыть" />
            <div class="clear"></div>
            <div class="discount_dialog_footer">
                <div class="name">кафе-галерея FLUER</div>
                <div class="button">
                    <input type="button" id="discount_submit" value="Скидка!" />
                </div>
            </div>
            <div style="text-align:center;font-size:10px; margin-bottom:5px;">Скидка бесплатна и действительна в течении 24 часов при предъявлении SMS официанту.
                <a href="/{//site/city}/content/rules">Правила</a>. Не действует на доставку.
            </div>
        </div>
    </xsl:template>

    <xsl:template name="message_dialog">
        <div id="message_dialog" class="box_shadow rounded_bottom">
            <div class="text"></div>
        </div>
    </xsl:template>

    <xsl:template name="empty_dialog">
        <div id="empty_dialog" class="dialog_box dialog box_shadow">
            <img class="close_button" src="/public/images/icons/close_icon.jpg" alt="закрыть" />
            <div class="clear"></div>
            <div class="content">
                
            </div>
        </div>
    </xsl:template>
</xsl:stylesheet>