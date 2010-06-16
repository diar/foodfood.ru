<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

    <xsl:template match="/">
        <div style="width:200px;float:left; padding-left:30px;">
            <h3 style="padding-left:20px;">Список скидок</h3>
            <a href="admin.php?page=discounts&amp;action=saveForRest" class="no_replace input_discount ui_button">
                Скачать для администраторов
            </a>
            <a href="admin.php?page=discounts&amp;action=saveForOff" class="no_replace input_discount ui_button">
                Скачать для официантов
            </a>
            <h3 style="padding-left:20px;">Добавить скидки</h3>
            <form method="post">
                <div class="input_label_log">Процент</div>
                <input name="percent" class="no_replace input_discount" />
                <div class="input_label_log">Количество</div>
                <input name="count" class="no_replace input_discount" />
                <div class="input_label_log">Описание</div>
                <textarea name="description" class="no_replace textarea_discount" />
                <input type="submit" class="no_replace input_discount ui_button" value="Добавить" />
            </form>
        </div>
        <div style="clear:both"><xsl:value-of select="content/message" /></div>
    </xsl:template>

</xsl:stylesheet>
