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
                    Оставить приглашение
                    <br />в ресторан
                    <xsl:value-of select="restaurant/title" />
                </div>
                <div class="message" id="dating_message"></div>
            </div>
            <div class="clear"></div>
            <div class="options">
                <div class="option">
                    <label>Актуальность</label>
                    <select id="dating_topicality">
                        <option>неделя</option>
                        <option>месяц</option>
                        <option>3 месяца</option>
                        <option>год</option>
                    </select>
                </div>
                <div class="option">
                    <label>Время</label>
                    <select id="dating_time">
                        <option>будни</option>
                        <option>выходные</option>
                    </select>
                </div>
                <div class="option">
                    <label>Цель знакомства</label>
                    <select id="dating_target">
                        <option>дружба</option>
                    </select>
                </div>
                <div class="clear"></div>
            </div>
            <textarea class="text" id="dating_text"></textarea>
            <input type="button" id="dating_submit" value="Оставить приглашение" />
        </div>
    </xsl:template>

</xsl:stylesheet>