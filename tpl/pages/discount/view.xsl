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
        <!-- Информация о ресторане -->
        <xsl:apply-templates select="partner" />
    </xsl:template >

    <!-- Информация о лице -->
    <xsl:template match="partner">
        <div class="restaurant_header rounded">
               
                <div class="caption">
                    <div class="title">
							Все скидки
                    </div>
                </div>
                
                <div class="select_percent">
                	<div class="percent50">
                    более 50
                    </div>
                    <div class="percent35">
                    35-50
                    </div>
                    
                    <div class="percent15">
                    15-35
                    </div>
                    
                    <div class="percent5">
                    5-15
                    </div>
                    
                    <div class="all">
                    все
                    </div>
                </div>
              
            </div>
           	<div class="discount_list">
            	<div class="item">
                	<div class="percent percent50 rounded shadow_box">
	                    50<span>%</span>
                    </div>
                    <div class="name"><a href="#">Четыре комнаты</a></div>
                    <div class="clear"></div>
                    <div class="count">осталось: 156</div>
                </div>
                
                <div class="item">
                	<div class="percent percent5 rounded shadow_box">
	                    10<span>%</span>
                    </div>
                    <div class="name"><a href="#">Четыре комнаты</a></div>
                    <div class="clear"></div>
                    <div class="count">осталось: 156</div>
                </div>
                
                <div class="item">
                	<div class="percent percent35 rounded shadow_box">
	                    40<span>%</span>
                    </div>
                    <div class="name"><a href="#">Четыре комнаты</a></div>
                    <div class="clear"></div>
                    <div class="count">осталось: 156</div>
                </div>
                
                <div class="item">
                	<div class="percent percent15 rounded shadow_box">
	                    20<span>%</span>
                    </div>
                    <div class="name"><a href="#">Четыре комнаты</a></div>
                    <div class="clear"></div>
                    <div class="count">осталось: 156</div>
                </div>
                
                
            </div>
            <div class="clear"></div>
            
            
            
    </xsl:template>

</xsl:stylesheet>