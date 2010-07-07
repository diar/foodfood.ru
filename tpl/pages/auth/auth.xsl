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
                <div class="title">Регистрация нового гурмана</div>
            </div>
            </div>
        </div>
        <div class="auth_page">
            <div id="registration_dialog" class=" dialog ">
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
        </div>
    </xsl:template >

</xsl:stylesheet>