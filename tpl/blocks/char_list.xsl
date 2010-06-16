<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>
    <xsl:template name="chars_list_latin">
        <span class="item">A</span>
        <span class="item">B</span>
        <span class="item">C</span>
        <span class="item">D</span>
        <span class="item">E</span>
        <span class="item">F</span>
        <span class="item">G</span>
        <span class="item">H</span>
        <span class="item">I</span>
        <span class="item">J</span>
        <span class="item">K</span>
        <span class="item">L</span>
        <span class="item">M</span>
        <span class="item">N</span>
        <span class="item">O</span>
        <span class="item">P</span>
        <span class="item">Q</span>
        <span class="item">R</span>
        <span class="item">S</span>
        <span class="item">T</span>
        <span class="item">U</span>
        <span class="item">V</span>
        <span class="item">W</span>
        <span class="item">X</span>
        <span class="item">Y</span>
        <span class="item">Z</span>
    </xsl:template>

    <xsl:template name="chars_list_rus">
        <span class="item">А</span>
        <span class="item">Б</span>
        <span class="item">В</span>
        <span class="item">Г</span>
        <span class="item">Д</span>
        <span class="item">Е</span>
        <span class="item">Ж</span>
        <span class="item">И</span>
        <span class="item">Й</span>
        <span class="item">К</span>
        <span class="item">Л</span>
        <span class="item">М</span>
        <span class="item">Н</span>
        <span class="item">О</span>
        <span class="item">П</span>
        <span class="item">Р</span>
        <span class="item">С</span>
        <span class="item">Т</span>
        <span class="item">У</span>
        <span class="item">Ф</span>
        <span class="item">Х</span>
        <span class="item">Ц</span>
        <span class="item">Ч</span>
        <span class="item">Ш</span>
        <span class="item">Щ</span>
        <span class="item">Э</span>
        <span class="item">Ю</span>
        <span class="item">Я</span>
    </xsl:template>

    <xsl:template name="chars_list_number">
        <span class="item">1</span>
        <span class="item">2</span>
        <span class="item">3</span>
        <span class="item">4</span>
        <span class="item">5</span>
        <span class="item">6</span>
        <span class="item">7</span>
        <span class="item">8</span>
        <span class="item">9</span>
        <span class="item">0</span>
    </xsl:template>
</xsl:stylesheet>