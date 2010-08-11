var recomended_max_width = 0;
var recomended_count = 0;
var recomended_item_width = 0;
var recomended_visible = 0;
var recomended_position = 0;
var recomended_block = false;
var recomended_counter = 2;
var by_mood_position = 0;
var by_mood_count = 0;
var by_mood_visible = 0;
var by_mood_block = false;
$(document).ready(function(){
						   
    // Проверка и обработка ширины экрана
    check_window_width ();
    // Затемнить блок скидок (Отключаем в ie - и так хватает там тормозов)
    if (!$.browser.msie) {
        discount_opacity_count = 0;
        $('.discounts .discount .rest_caption a').each(function(){
            opacity = 1 - (discount_opacity_count*0.1);
            $(this).css({
                'opacity':opacity
            });
            discount_opacity_count = discount_opacity_count + 1;
        });
    }
    // Нажатие на кнопку со скидкой
    $('.discount').click(function(){					
        $('#discount_submit').attr('partner',$(this).attr('partner'));
        title = $(this).find('.rest_caption a').html();
        des = $(this).find('.description').html();
        percent = parseInt($(this).find('.percent').html());
        $('#discount_dialog .name').html(title);
        $('#discount_dialog .description_discount').html(des);
        $('#discount_dialog .discount_percent .number').html(''+percent+'<span>%</span>');
        $.showDialog('discount_dialog');
        return false;
    });
    /*
     * Скрытие панели с дополнительной информацией
     */
    $('.additional_hide_bar img').click(function(){
        id = $(this).attr('id');
        $('#'+id+'_content').each(function(){
            if ($(this).css('display')=='none') {
                $(this).animate({
                    'opacity':'show'
                },400);
                $('.additional_hide_bar:has(#'+id+')').css({
                    'background':'white'
                });
            }
            else $(this).animate({
                'opacity':'hide'
            },400,function(){
                $('.additional_hide_bar:has(#'+id+')').css({
                    'background':'#c8c8c8'
                });
            });
        });
    });
    // Нажатие на кнопку "вперед" прокрутки рекомендуемых ресторанов
    $('#recomended .next').click(function(){
        if (!recomended_block && recomended_position<recomended_count-recomended_visible) {
            recomended_block = true;
            var counter=recomended_counter;
            if (recomended_position+counter>recomended_count-recomended_visible) {
                counter=recomended_count-recomended_visible-recomended_position;
            }
            item_width=$("#recomended_container .item").width()+20;
            scroll_left=$("#recomended_container").scrollLeft()+(item_width*counter);
            $("#recomended_container").animate({
                scrollLeft:scroll_left
            },300,function(){
                recomended_block = false;
                ij = 0;
                $('#recomended_gallery .img img').each(function(){
                    ij++;
                    if (recomended_position + recomended_visible +1 > ij
                        && typeof($(this).attr('src'))=='undefined') {
                        $(this).attr('src',$(this).attr('rel')).attr('rel','');
                    }
                });
            });
            recomended_position=recomended_position+counter;
            if (recomended_position==recomended_count-recomended_visible) {
                $(this).css('backgroundPosition','0 0');
            }
            else {
                $(this).css('backgroundPosition','0 -24px');
            }
            if (recomended_position==0) {
                $('#recomended .back').css('backgroundPosition','0 -48px');
            } else {
                $('#recomended .back').css('backgroundPosition','0 -72px');
            }
        }
    });
    // Нажатие на кнопку "назад" прокрутки рекомендуемых ресторанов
    $('#recomended .back').click(function(){
        if (!recomended_block && recomended_position>0) {
            recomended_block = true;
            var counter=recomended_counter;
            if (recomended_position-counter<0) {
                counter=1;
            }
            item_width=$("#recomended_container .item").width()+20;
            scroll_left=$("#recomended_container").scrollLeft();
            $("#recomended_container").animate({
                scrollLeft:scroll_left-(item_width*counter)
            },300,function(){
                recomended_block = false;
            });
            recomended_position=recomended_position-counter;
            if (recomended_position==0) {
                $(this).css('backgroundPosition','0 -48px');
            } else {
                $(this).css('backgroundPosition','0 -72px');
            }
            if (recomended_position==recomended_count-recomended_visible) {
                $('#recomended .next').css('backgroundPosition','0 0');
            } else {
                $('#recomended .next').css('backgroundPosition','0 -24px');
            }
        }
    });
    // Нажатие на кнопку отзыв - минус
    $('.rest_rating .minus').click(function(){
        $('.rest_rating .rating_comment').fadeOut();
        update_rating_form($(this),-1);
    });
    // Нажатие на кнопку отзыв - плюс
    $('.rest_rating .plus').click(function(){
        $('.rest_rating .rating_comment').fadeOut();
        update_rating_form($(this),1);
    });
    // Действие при изменении ширины экрана
    if (!$.browser.msie) {
        $(window).resize(function () {
            if (typeof(size_timeout)!='undefined') clearTimeout(size_timeout);
            size_timeout = setTimeout('check_window_width ()', 300);
        });
    }
});
/*
 * Проверка и обработка ширины экрана
 */
function check_window_width () {
    mood_check_width ();
    poster_check_width ();
    article_check_width ();
    recomended_check_width ();
}
/*
 * Добавление и отображения формы добавления отзыва
 */
function update_rating_form(parent,target){
    parent.html('');
    if(user_auth=='1') {
        rating_form = $(
            '<div class="rating_comment">'+
            '<div class="closeButton"><img src="/public/images/icons/close_icon.jpg" /></div>'+
            '<form>'+
            '<textarea class="rounded">Нет слов...</textarea>'+
            '<input type="submit" value="Вот так." class="rounded" />'+
            '</form>'+
            '</div>'
            );
    } else {
        rating_form = $(
            '<div class="rating_comment message">'+
            '<div class="closeButton"><img src="/public/images/icons/close_icon.jpg" /></div>'+
            '<div class="reg"><span>Вы должны </span><a href="#" class="registration_link">зарегистрироваться</a>'+
            '<span> или </span><a href="#" class="login_link">войти на сайт</a>'
            +'<span> чтобы оставлять отзывы</span></div>'+
            '</div>'
            );
    }
    parent.append(rating_form);
    $('.login_link').click(function(){
        $('#auth_message').html('');
        $.showDialog('auth_dialog');
    });
    $('.registration_link').click(function(){
        $.showDialog('registration_dialog');
    });
    rating_form.fadeIn();
    rating_form.find('.closeButton').click(function(){
        $(this).parent('.rating_comment').fadeOut();
        return false;
    });
    rating_form.find('input[type=submit]').click(function(){
        rest_id = $(this).parents('.item').attr('rel');
        text = $(this).parent().find('textarea').val();
        $.post('/'+site_city+'/restaurant/comment/'+rest_id+'/',
        {
            'text':text,
            'target':target
        },
        function (data) {
            if (data=='OK') $.alert('Ваш голос учтен',false);
            else if (data=='NO_LOGIN') $.alert('Вы должны войти на сайт, чтобы оставлять отзывы',true);
            else if (data=='ALREADY') $.alert('Вы уже голосовали за этот ресторан',true);
            else if (data=='LENGTH') $.alert('Длина отзыва не должна превышать 1000 символов',true);
            else if (data=='MAT') $.alert('Ваш отзыв не принят из-за мата',true);
            else if (data=='FMIN') $.alert('Вы не можете оставлять более 1 отзыва ресторану за 5 минут',true);
            else $.alert('Ошибка. Попробуйте еще раз',true);
        });
        return false;
    });
    rating_form.click(function(){
        return false;
    });
}

/*
 * Обработка ширины блоков рекомендуемых ресторанов
 */
function recomended_check_width () {
    recomended_count=0;
    recomended_item_width=$("#recomended_container .item").width()+20;
    if (!$.browser.msie) recomended_visible = Math.ceil(($(document).width()-270)/recomended_item_width)-1;
    else recomended_visible = Math.ceil((screen.width-270)/recomended_item_width)-1;
    recomended_container_width=recomended_visible*recomended_item_width-10;
    $('#recomended_container').css({
        'width':recomended_container_width
    });
    $('#recomended_gallery .img img').each(function(){
        recomended_count++;
        $(this).load(function(){
            $(this).animate({
                'opacity':'show'
            },400);
        });
        if (recomended_count<recomended_visible+1 && typeof($(this).attr('src'))=='undefined') {
            $(this).attr('src',$(this).attr('rel')).attr('rel','');
        }
    });
    $('#recomended_container').css('background','none');
    recomended_max_width=recomended_count*recomended_item_width;
}

/*
 * Обработка ширины блоков афиш
 */
function poster_check_width () {
    $('#restaurant_poster .poster_block').css('display','none');
    if (!$.browser.msie) poster_add_count = Math.ceil(($(document).width()-588)/271)-1;
    else poster_add_count = Math.ceil((screen.width-603)/271)-1;
    $('#restaurant_poster .poster_block').each(function(){
        if(poster_add_count>0) {
            $(this).animate({
                'width':'show'
            },100);
            $(this).find('img').each(function(){
                if (typeof($(this).attr('src'))=='undefined') {
                    $(this).attr('src',$(this).attr('rel')).attr('rel','');
                }
            });
            poster_add_count--;
        }
    });
}

/*
 * Обработка ширины блоков статей
 */
function article_check_width () {
    $('#restaurant_article .article_block').css('display','none');
    if (!$.browser.msie) article_add_count = Math.ceil(($(document).width()-588)/271)-1;
    else article_add_count = Math.ceil((screen.width-603)/271)-1;
    $('#restaurant_article .article_block').each(function(){
        if(article_add_count>0) {
            $(this).animate({
                'width':'show'
            },100);
            article_add_count = article_add_count -1;
        }
    });
}