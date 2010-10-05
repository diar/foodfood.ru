<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

    <xsl:template match="/">
    
        <div class="title"><xsl:value-of select="root/page_title" /></div>
        <form action="{root/save_link}" enctype="multipart/form-data" method="post">
        <div class="form">        
        	<div class="field">
            	<label for="title">Название</label>
                <input type="text" name="title" maxlength="150" value="{root/title}"/>
            </div>
            <div class="field">
            	<label for="country">Страна производитель</label>
                <input type="text" name="country" maxlength="100" value="{root/country}"/>
            </div>
            <div class="field">
            	<label for="expire_date">Срок годности</label>
                <input type="text" name="expire_date" maxlength="15" value="{root/expire_date}"/>
            </div>
            <div class="field">
            	<label for="image">Изображение</label>
                <input type="file" name="image" />
                <div class="help">Можно загрузить файл формата JPG, GIF или PNG.</div>
            </div>
            <div class="field">
            	<label for="image">Малое изображение</label>
                <input type="file" name="tmb_image" />
                <div class="help">Можно загрузить файл формата JPG, GIF или PNG.</div>
            </div>
            <div class="field">
            	<label for="description">Описание</label>
                <textarea name="description" ><xsl:value-of select="root/description" disable-output-escaping="no" /></textarea>
            </div>
            <div class="field">
            	<label for="composition">Содержание</label>
                <textarea name="composition" ><xsl:value-of select="root/composition" disable-output-escaping="no" /></textarea>
            </div>
            <div class="field">
            	<label for="ccal">Энергетическая / пищевая ценность на 100 г.</label>
                <textarea name="ccal" ><xsl:value-of select="root/ccal" disable-output-escaping="no" /></textarea>
            </div>
            <div class="field">
            	<label for="packing">Упаковка</label>
                <select name="packing">
                	<xsl:apply-templates select="root/boxes" />
                </select>
            </div>
            <div class="field">
            	<table id="size_price">
                	<tr>
                    	<th><label for="size">Вес или объем</label></th>
                        <th><label for="price">Цена</label></th>
                    </tr>
                    <xsl:choose>
                    	<xsl:when test="root/size_price != ''">
	                        <xsl:apply-templates select="root/size_price" />
                        </xsl:when>
                        <xsl:otherwise>
                            <tr>
                                <td><input type="text" name="size[]"  /></td>
                                <td><input type="text" name="price[]" /></td>
                                <td><div class="function_line del_line" >-</div></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="size[]"  /></td>
                                <td><input type="text" name="price[]" /></td>
                                <td><div class="function_line add_line" >+</div></td>
                            </tr>
                        </xsl:otherwise>
                    </xsl:choose>
                    
                    
                    
                </table>
            </div>
            <div class="field">
            	<label for="keywords">Ключевые слова</label>
                <input type="text" name="keywords" value="{root/keywords}" />
                <div class="help">Вводить через запятую</div>
            </div>
            <div class="field">
            	<label for="url">URL</label>
                <input type="text" name="url" value="{root/url}" />
            </div>
            <div class="field additional">
            	<input type="checkbox" name="is_bio" value="1">
                	<xsl:if test="root/is_bio = 1">
                    	<xsl:attribute name="checked">checked</xsl:attribute>
                    </xsl:if>
                </input>
                <label for="is_bio">Био продукт</label><br />
				<input type="file" name="sertificat" style="margin-left:22px;margin-top:10px;" />
            </div>
            <div class="field submit">
            	<input type="hidden" value="{root/id}" name="id"/>
                <input type="hidden" value="{root/parent_id}" name="parent_id"/>
            	<input type="submit" value="Сохранить изменения" />
                <input type="button" value="Отменить" />
            </div>
            
        </div>
        <div class="additional_block">
        	
            	<div class="field"><input type="radio" name="type" value="Новый продукт">
                        <xsl:if test="root/type = 'Новый продукт'">
                            <xsl:attribute name="checked">checked</xsl:attribute>
                        </xsl:if>
                    </input>     <label for="type">Новый продукт</label></div>
            	<div class="field">
                	<input type="radio" name="type" value="Рекомендовано" >
                        <xsl:if test="root/type = 'Рекомендовано'">
                            <xsl:attribute name="checked">checked</xsl:attribute>
                        </xsl:if>
                    </input>    
                    <label for="type">Рекомендовано</label></div>
            	<div class="field">
                	<input type="radio" name="type" value="Обычный" >
                        <xsl:if test="root/type = 'Обычный'">
                            <xsl:attribute name="checked">checked</xsl:attribute>
                        </xsl:if>
                    </input>   
                    <label for="type">Обычный</label>
                </div>
                <div class="field">
                    <input type="checkbox" name="expired" value="1">
                        <xsl:if test="root/expired = 1">
                            <xsl:attribute name="checked">checked</xsl:attribute>
                        </xsl:if>
                    </input> 
                    <label for="type">Нет в наличии</label>
                </div>
                <div class="field">
                	<input type="checkbox" name="hidden" value="1">
                        <xsl:if test="root/hidden = 1">
                            <xsl:attribute name="checked">checked</xsl:attribute>
                        </xsl:if>
                    </input>  
                    <label for="type">Скрытый</label>
                </div>
                <div class="field" style="margin-left:25px;">
                	<label for="type">Скидка в процентах</label><br />
                    <input type="text" name="discount" value="{root/discount}"/>
                </div>
            
        </div>
        </form>
        
    </xsl:template>

    <xsl:template match="size_price/item">
        <tr>
            <td><input type="text" name="size[]" value="{size}" /></td>
            <td><input type="text" name="price[]" value="{price}"/></td>
            <td><div class="function_line add_line">+</div></td>
        </tr>
    </xsl:template>
    <xsl:template match="boxes/item">
	    <option value="{id}">
        <xsl:if test="//root/packing = id">
        	<xsl:attribute name="selected">selected</xsl:attribute>
        </xsl:if>
        <xsl:value-of select="title" />
        </option>
    </xsl:template>

</xsl:stylesheet>