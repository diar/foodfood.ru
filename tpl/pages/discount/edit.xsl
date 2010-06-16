<?xml version="1.0" encoding="UTF-8"?>
<!-- Страница редактирования информации о ресторане (временная) -->
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

    <!-- Импорт макета -->
    <xsl:include href="../../layouts/discount.xsl" />
    <xsl:template match="/">
        <xsl:apply-templates select="root" />
    </xsl:template >

    <!-- Код страницы -->
    <xsl:template match="content">
        <div id="discount_header">
            <div id="discount_logo">
                <a href="/"><img src="/public/images/discount_logo.jpg" /></a>
                <div>Запуск весной</div>
            </div>
            <div id="discount_menu">
                <a href="/{../site/city}/discount/logout" >Выйти</a>
            </div>
        </div>
        <div class="clear"></div>
        <div id="discount_content" class="edit">
            <div id="discount_left" class="edit">
                <div id="discount_happy">Настроение есть!</div>

                <div id="titleEdit">
                    <div class="tahoma24px000000">Добрый день!</div>
                    <div class="tahoma14px000000">Заполните пожалуйста информацию о Вас:</div>
                </div>

                <div id="formEdit">
                    <form method="post" enctype="multipart/form-data">
                        <div class="caption">Название</div><div class="input"><input type="text" name="rest_title" value="{info/rest_title}" /></div>
                        <div class="delimiter"></div>
                        <div class="caption">Имя администратора</div><div class="input"><input type="text" name="admin_name" value="{info/admin_name}" /></div>
                        <div class="delimiter"></div>
                        <div class="caption">Контактный номер администратора</div><div class="input"><input type="text" name="admin_phone" value="{info/admin_phone}" /></div>
                        <div class="delimiter"></div>
                        <div class="caption">Контактный номер ресторана</div><div class="input"><input type="text" name="rest_phone" value="{info/rest_phone}" /></div>
                        <div class="delimiter"></div>
                        <div class="caption">Количество ресторанов</div><div class="input"><input type="text" name="rest_count" value="{info/rest_count}" /></div>
                        <div class="delimiter"></div>
                        <div class="caption">Фотографии</div><div id="photo_upload" class="photo_upload"></div><input type="file" name="fileToUpload[]"  class="MultiFile" />
                        <div class="delimiter"></div>
                        <div class="caption">Загрузить описание</div><div id="photo_upload" class="photo_upload"></div><input type="file" name="fileToUpload[]"  class="MultiFile" />
                        <div class="delimiter"></div>
                        <div class="caption">Загрузить меню</div><div id="photo_upload" class="photo_upload"></div><input type="file" name="fileToUpload[]"  class="MultiFile" />
                        <div class="delimiter"></div>
                        <div class="caption">Сайт</div><div class="input"><input type="text" name="rest_link" value="{info/rest_link}" /></div>
                        <div class="delimiter"></div>
                        <div class="caption">Адресс</div><div class="textarea"><textarea name="rest_address"><xsl:value-of select="info/rest_address" /></textarea></div>
                        <div class="delimiter"></div>
                        <div class="caption">Предлагаемая скидка</div><div class="shortInput"><input type="text" name="max_skidka" value="{info/max_skidka}" /></div><div class="help">(не менее 7%)</div>
                        <div class="delimiter"></div>
                        <div class="caption">Сумма среднего чека</div><div class="input"><input type="text" name="rest_check" value="{info/rest_check}" /></div>
                        <div class="delimiter"></div>
                        <div class="caption">Количество мест</div><div class="shortInput"><input type="text" name="rest_banket_count" value="{info/rest_banket_count}" /></div>
                        <div class="delimiter"></div>
                        <div class="caption">Банкет человек / руб.</div><div class="shortInput"><input type="text" name="rest_banket_min_check" value="{info/rest_banket_min_check}" /></div>
                        <div class="delimiter"></div>
                        <div class="delimiter"></div>
                        <div class="caption"></div><div><input id="edit_rest_submit" type="submit" value="" /></div>
                    </form>
                    <div id="discount_copyright">
                        <div><xsl:value-of select="../site/copyright" /></div>
                        <div><xsl:value-of select="../site/contact" /></div>
                    </div>
                </div>
            </div>

            <div id="discount_right" class="edit">
                <div class="tahoma24px000000boldItalic">Для участия в проекте вам необходимо:</div>
                <div class="list tahoma14px000000">
                    <div class="number">1.</div><div class="text">Заполнить информацию о Вашем ресторане;</div>
                    <div class="delimiter"></div>
                    <div class="number">2.</div><div class="text">Предоставить скидку на меню не менее 7%;</div>
                    <div class="delimiter"></div>
                    <div class="number">3.</div><div class="text">Заключение договора на полгода;</div>
                    <div class="delimiter"></div>
                    <div class="number">4.</div><div class="text">Выбрать время для фотосессии.</div>
                    <div class="delimiter"></div>
                </div>
                <div class="tahoma24px000000boldItalic">Почему Food Food?</div>
                <div class="list tahoma14px000000">
                    <div class="number">1.</div><div class="text">Мобильные технологии;</div>
                    <div class="delimiter"></div>
                    <div class="number">2.</div><div class="text">Высокий уровень контента;</div>
                    <div class="delimiter"></div>
                    <div class="number">3.</div><div class="text">Профессиональная съемка событий, интерьера;</div>
                    <div class="delimiter"></div>
                    <div class="number">4.</div><div class="text">Общение пользователей (соц. сеть, блоги);</div>
                    <div class="delimiter"></div>
                    <div class="number">5.</div><div class="text">Быстрый сервис по бронированию столиков;</div>
                    <div class="delimiter"></div>
                    <div class="number">6.</div><div class="text">Удобный сервис организация банкетов;</div>
                    <div class="delimiter"></div>
                    <div class="number">7.</div><div class="text">База ведущих и музыкантов;</div>
                    <div class="delimiter"></div>
                    <div class="number">8.</div><div class="text">Доставка еды.</div>
                    <div class="delimiter"></div>
                </div>
                <div class="question">
                    <div class="icon">
                        <img src="/public/images/discount_question_icon.png" alt="" />
                    </div>
                    <div class="contact tahoma18px000000boldItalic">
                        Возникли вопросы? <br />
                        Звоните: 5-700-919
                    </div>
                </div>
                <div class="" />
                <a href="/public/files/template_resto.doc" style="margin-left:35px;color:black;display:none;">Скачать договор</a>
            </div>
        </div>
    </xsl:template >
</xsl:stylesheet>