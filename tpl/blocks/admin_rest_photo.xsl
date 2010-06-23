<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

    <xsl:template match="/">
        <script type="text/javascript" src="js/photos.js"></script>
        <div id="photos_container">
            <div>Нажмите для загрузки фотографии</div>
            <form id="imgform" method="post" enctype="multipart/form-data"
                  action="/admin/admin.php?page=restPhotos&amp;action=add" target="frame">
                <input type="file" name="img" id="image" />
            </form>
            <div id="photo_panel">
                <input type="button" id="photo_delete" value="удалить выделенное" />
            </div>
            <div style="clear:both"></div>
            <div id="photos">
                <xsl:apply-templates select="root/photos/item" />
            </div>
            <div style="clear:both"></div>
        </div>
        <h3>Информация</h3>
        <div id="photo_info"></div>
        <iframe id="frame" style="display:none" name="frame"></iframe>
    </xsl:template>

    <xsl:template match="item">
        <div class="photo_container">
            <div class="photo_item" id="photo{id}">
                <img src="{//web_dir}{src}" class="photo" />
            </div>
        </div>
    </xsl:template>

</xsl:stylesheet>