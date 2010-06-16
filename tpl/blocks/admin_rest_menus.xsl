<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

    <xsl:template match="/">
        <script type="text/javascript" src="js/menus.js"></script>
        <div id="photos_container">
            <div>Нажмите для загрузки меню</div>
            <form id="imgform" method="post" enctype="multipart/form-data"
                  action="/admin/admin.php?page=restMenus&amp;action=add" target="frame">
                <input type="file" name="img" id="image" />
            </form>
            <div id="photo_panel">
                <input type="button" id="photo_delete" value="Удалить выделенное" />
            </div>
            <div style="clear:both"></div>
            <div id="docs">
                <xsl:apply-templates select="root/docs/item" />
            </div>
            <div style="clear:both"></div>
        </div>
        <iframe id="frame" style="display:none" name="frame"></iframe>
    </xsl:template>

    <xsl:template match="item">
        <div class="doc" id="doc{id}"><xsl:value-of select="title" /></div>
    </xsl:template>

</xsl:stylesheet>
