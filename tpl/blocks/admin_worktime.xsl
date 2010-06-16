<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

    <xsl:template match="/">
        <script type="text/javascript" src="js/worktime.js"></script>
        <table id="worktime">
            <tr>
                <td>День недели</td>
                <td>Время</td>
                <td></td>
            </tr>
            <xsl:apply-templates match="root/rows/item" />
            <tr id="copipaster">
                <td class="week">
                    <select class="start"><xsl:call-template name="weeks"/></select> -
                    <select class="end"><xsl:call-template name="weeks"/></select>
                </td>
                <td class="time">
                    <select class="start hour"><xsl:call-template name="hours"/></select>
                    <select class="start minute"><xsl:call-template name="minuts"/></select> -
                    <select class="end hour"><xsl:call-template name="hours"/></select>
                    <select class="end minute"><xsl:call-template name="minuts"/></select>
                </td>
                <td><a href="#" class="remove_worktime">удалить</a></td>
            </tr>
        </table>
        <a href="#" id="add_worktime">Добавить</a>
        <a href="#" id="save_worktime">Сохранить</a>
    </xsl:template>

    <xsl:template match="rows/item">
        <tr class="row_worktime">
            <td class="week">
                <select class="start" selected="{day_start}"><xsl:call-template name="weeks"/></select> -
                <select class="end" selected="{day_end}"><xsl:call-template name="weeks"/></select>
            </td>
            <td class="time">
                <select class="start hour" selected="{hour_start}"><xsl:call-template name="hours"/></select>
                <select class="start minute" selected="{minute_start}"><xsl:call-template name="minuts"/></select> -
                <select class="end hour" selected="{hour_end}"><xsl:call-template name="hours"/></select>
                <select class="end minute" selected="{minute_end}"><xsl:call-template name="minuts"/></select>
            </td>
            <td><a href="#" class="remove_worktime">удалить</a></td>
        </tr>
    </xsl:template>

    <xsl:template name="weeks">
        <option value="1">понедельник</option>
        <option value="2">вторник</option>
        <option value="3">среда</option>
        <option value="4">четверг</option>
        <option value="5">пятница</option>
        <option value="6">суббота</option>
        <option value="7">воскресенье</option>
    </xsl:template>

    <xsl:template name="hours">
        <option value="00">00</option>
        <option value="01">01</option>
        <option value="02">02</option>
        <option value="03">03</option>
        <option value="04">04</option>
        <option value="05">05</option>
        <option value="06">06</option>
        <option value="07">07</option>
        <option value="08">08</option>
        <option value="09">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="23">23</option>
    </xsl:template>

    <xsl:template name="minuts">
        <option value="00">00</option>
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="30">30</option>
        <option value="40">40</option>
        <option value="50">50</option>
    </xsl:template>

</xsl:stylesheet>
