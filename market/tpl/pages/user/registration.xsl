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
		<div class="title" style="margin-left:1em;">Регистрация</div>
        <div class="auth_form">
        	
            <div class="formField">
	            <div class="error"><xsl:value-of select="message" disable-output-escaping="yes"/></div>
                <form action="/user/registration" method="post">
                <div class="field">
                    <label for="login">e-mail</label><br />
                    <input type="text" name="email" id="email" />
                </div>
                <div class="field">
                    <label for="login">Имя</label><br />
                    <input type="text" name="name" id="name" />
                </div>
                <div class="field" style="text-align:center;"><input type="checkbox" id="apply" name="apply" value="1" /> Ознакомлен с правилами </div>
                <div class="field" style="text-align:center;">
	                <input type="submit" name="submit" value="Регистрация" />
                </div>
				</form>
            </div>
        </div>
        <div class="clear"></div>
    </xsl:template>

   



</xsl:stylesheet>