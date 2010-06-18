<?xml version="1.0" encoding="UTF-8"?>
<!-- Страница ошибки 404 -->
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>
    <!-- Импорт макета -->
    <xsl:template match="/">
        <xsl:apply-templates select="root" />
    </xsl:template >

    <!-- Код страницы -->
    <xsl:template match="root">
    <html>
    	<head>
        	<link rel="icon" type="image/vnd.microsoft.icon"  href="/public/images/favicon.ico" />
            <link rel="stylesheet" type="text/css" href="/public/css/style.css" />
            <title>Ошибка 404. Страница не найдена.</title>
        </head>
        <body class="error404">
        <div class="error404">
			<div class="logo404"><a href="/"><img src="/public/images/logo404.jpg" /></a></div>
			<div class="text404">
				<div class="title404">Страница не найдена</div>
				<div class="text404">Страница, которую вы запросили, отсутствует на нашем портале.<br />
Возможно, вы ошиблись при наборе адреса или перешли по неверной ссылке.
</div>
				<div class="menu404">
                  <a href="/kazan/poster">Афиша</a>
                  <a href="/kazan/discount">Скидки</a>
                  <a href="/blog/">Блоги</a>
                  <a href="/blog/people/">Гурманы</a>
                  <a href="/market/">Доставка</a>
                </div>
			</div>

		</div>
        </body>
    </html>
    </xsl:template>
</xsl:stylesheet>