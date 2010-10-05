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
		<div class="title" style="margin-left:1em;">Вход в магазин</div>
        <div class="auth_form">
        	
            <div class="formField">
	            <div class="error"><xsl:value-of select="error" /></div>
                <form action="/user/auth" method="post">
                <div class="field">
                    <label for="login">E-Mail</label><br />
                    <input type="text" name="login" id="login" />
                </div>
                <div class="field">
                    <label for="login">Пароль</label><br />
                    <input type="password" name="password" id="password" />
                </div>
                <div class="field" style="text-align:center;"><input type="checkbox" id="remember" name="remember" value="1" /> Запомнить меня</div>
                <div class="field" style="text-align:center;">
	                <input type="submit" name="submit" value="Войти" />
                </div>
				</form>
            </div>
            <div class="alignRight" style="padding-right:30px;">
				<a href="/user/registration" class="reg">Зарегистрироваться</a><br />
				<a href="/user/remember" class="remember">Восстановление пароля</a>
            </div>
        </div>
        <div class="clear"></div>
    </xsl:template>

   



</xsl:stylesheet>