<?xml version="1.0" encoding="UTF-8"?>
<!-- Страница лица фуд фуд -->
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
        <div id="additional">
            <div class="restaurant_header rounded">
                <div class="margin0autoMax-width1600">
                    <div class="caption">
                        <div class="title">
                            <xsl:comment>
                                <xsl:value-of select="person_title" />
                            </xsl:comment>
                            <span id="person_name_caption"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="contest_users">
                <h2>Участники конкурса:</h2>
                <p>
                    <table>
                        <tr style="font-size:12px;color:#777;">
                        <td style="width:60px;"></td>
                        <td>имя пользователя</td>
                        <td style="text-align:right;">кол-во приглашенных</td>
                        </tr>
                        <xsl:apply-templates select="users/item" />
                    </table>
                </p>
            </div>
        </div>
    </xsl:template >

    <xsl:template match="users/item">
        <tr>
            <td style="width:60px;">
                <xsl:choose>
                    <xsl:when test="user_profile_avatar!=''">
                        <img src="{user_profile_avatar}" style="width:48px;" />
                    </xsl:when>
                    <xsl:otherwise>
                        <img src="/blog/templates/skin/new/images/avatar_48x48.jpg" style="width:48px;" />
                    </xsl:otherwise>
                </xsl:choose>
            </td>
            <td style="vertical-align:middle">
                <a style="font-size:18px" href="/blog/profile/{user_login}" >
                    <xsl:value-of select="user_login" />
                </a>
            </td>
            <td class="right">
                <xsl:value-of select="count" />
            </td>
        </tr>
    </xsl:template>

</xsl:stylesheet>