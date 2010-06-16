<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

    <xsl:template match="/">
        <form method="POST" action="/admin/">
            <table style="width:100%;height:100%">
                <tr>
                    <td>
                        <table align="center">
                            <tr><td colspan="2">Авторизация администратора</td></tr>
                            <tr><td>Логин</td><td><input type="text" name="login" /></td></tr>
                            <tr><td>Пароль</td><td><input type="password" name="password" /></td></tr>
                            <tr><td>Город</td><td><select name="city">
                                        <xsl:apply-templates select="root/city" />
                            </select></td></tr>
                            <tr><td></td><td><input name="submit" type="submit" value="Войти..." /></td></tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </xsl:template>

    <xsl:template match="city/item">
        <option value='{id}'><xsl:value-of select="city"/></option>
    </xsl:template>

</xsl:stylesheet>