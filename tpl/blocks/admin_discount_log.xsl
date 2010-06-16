<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

    <xsl:template match="/">
        <div style="width:200px;float:left; padding-left:30px;">
            <a class="input_log ui_button" href="/admin/admin.php?page=discountLog&amp;action=showCSV">Скачать CSV</a>
            <a class="input_log ui_button" href="/admin/admin.php?page=discountLog&amp;action=showXLSX">Скачать Excel</a>

            <form method="post">
                <div class="input_label_log">E-mail</div>
                <input name="email" class="no_replace input_log" value="{root/admin/email}" />
                <div class="input_label_log">Номер</div>
                <input name="phone" class="no_replace input_log" value="{root/admin/phone}" />
                <div>
                    <input name="is_email" type="checkbox" class="no_replace" style="margin-left:10px;">
                        <xsl:choose>
                            <xsl:when test="root/admin/send_log_email=1">
                                <xsl:attribute name="checked">checked</xsl:attribute>
                            </xsl:when>
                        </xsl:choose>
                    </input>
                    <span class="input_label_log" style="margin-left:0;">Отправлять на e-mail</span>
                </div>
                <div>
                    <input name="is_phone" type="checkbox" class="no_replace" style="margin-left:10px;">
                        <xsl:choose>
                            <xsl:when test="root/admin/send_log_email=1">
                                <xsl:attribute name="checked">checked</xsl:attribute>
                            </xsl:when>
                        </xsl:choose>
                    </input>
                    <span class="input_label_log" style="margin-left:0;">Отправлять на номер</span>
                </div>
                <input type="submit" class="no_replace input_log ui_button" value="Сохранить" />
            </form>
        </div>
    </xsl:template>

</xsl:stylesheet>
