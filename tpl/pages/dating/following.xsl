<?xml version="1.0" encoding="UTF-8"?>
<!-- Страница для получения списка ресторанов по настроению через Ajax -->
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>
    <xsl:template match="/">
        <xsl:apply-templates select="root/content" />
    </xsl:template>

    <!-- Список ресторанов -->
    <xsl:template match="content">
        <div id="dating_dialog">
            <div class="caption">
                <div class="title">
                    <img src="{inviter/user_profile_avatar}" style="float:left;width:80px;" />
                    Принять приглашение <br />
                    в ресторан
                    "<xsl:value-of select="restaurant/title" />"<br />
                    от 
                    <a href="/blog/profile/{inviter/user_login}/">
                        <xsl:value-of select="inviter/user_login" />
                    </a>
                </div>
                <div class="message" id="dating_message"></div>
            </div>
            <div class="clear"></div>
            <div class="options">
                <div class="option">
                    <label>Актуальность</label>
                    <div class="inp rounded"><xsl:value-of select="inviter/dating_topicality" /></div>
                </div>
                <div class="option">
                    <label>Время</label>
                    <div class="inp"><xsl:value-of select="inviter/dating_time" /></div>
                </div>
                <div class="option">
                    <label>Цель знакомства</label>
                    <div class="inp"><xsl:value-of select="inviter/dating_target" /></div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="inp text"><xsl:value-of select="inviter/dating_text" /></div>
            <input type="button" id="dating_follow_submit" value="Оставить номер" />
        </div>
    </xsl:template>

</xsl:stylesheet>