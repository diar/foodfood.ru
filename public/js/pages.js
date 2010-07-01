var restaurant_photo_count = 0;
var restaurant_photo_visible = 6;
var restaurant_photo_offset = 0;
var restaurant_photo_position = 0;
var person_item_count = 0;
var person_item_offset = 0;
var person_item_position = 0;
var person_item_visible = 0;
var poster_month_position = 0;
var poster_month_count = 0;
var poster_day_position = 0;
var poster_day_count = 0;
var poster_day_visible = 0;
var week_days = Array('вс','пн','вт','ср','чт','пт','сб');
$(document).ready(function(){
    // Проверка и обработка ширины экрана
    check_window_width ();
    // Подключаем обрпботчик изменеия ширины экрана
    if (!$.browser.msie) {
        $(window).resize(function () {
            check_window_width()
        });
    }

    /* ---------------------------------------------------------------------
    * Если находимся на странице вывода ресторана
    */
    if (typeof(rest_page_activate)!='undefined') {
        $('.main_container a').lightBox({
            imageLoading: '/public/js/libs/lightbox/images/lightbox-ico-loading.gif',
            imageBtnClose:'/public/js/libs/lightbox/images/lightbox-btn-close.gif',
            imageBtnPrev: '/public/js/libs/lightbox/images/lightbox-btn-prev.gif',
            imageBtnNext: '/public/js/libs/lightbox/images/lightbox-btn-next.gif',
            imageBlank:   '/public/js/libs/lightbox/images/lightbox-blank.gif',
            fixedNavigation:true
        });
        $('#restaurant_info .photos .main').first().show().addClass('current');
        ;
        // Нажатие на кнопку со скидкой
        $('.link.discount_icon a').click(function(){
            $('#discount_submit').attr('partner',$(this).attr('partner'));
            title = $('.caption .title').html();
            percent = $(this).attr('percent');
            description = $(this).parent().find('.discount_description').html();
            $('#discount_dialog .name').html(title);
            $('#discount_dialog .description_discount').html(description);
            $('#discount_dialog .discount_percent .number').html(''+percent+' <span>%</span>');
            $.showDialog('discount_dialog');
            return false;
        });
        /*
        * Инициализация превью фоток
        */
        $('#restaurant_info .photos .mini').each(function(){
            restaurant_photo_count++;
            if (restaurant_photo_count<=restaurant_photo_visible) {
                $(this).show();
            }
            $(this).attr('pos',restaurant_photo_count);
        });
        /*
        * Нажатие на превью фотки ресторана
        */
        $('#restaurant_info .photos .mini').click(function(){
            min = this;
            $('#restaurant_info .photos .mini.active').removeClass('active');
            $(min).addClass('active');
            $('#restaurant_info .photos .main.current').removeClass('current').fadeOut(300,function(){
                $('#restaurant_info .photos .main[src="'+$(min).attr('rel')+'"]').fadeIn(300).addClass('current');
                $('#restaurant_info .photos .main[src="'+$(min).attr('rel')+'"] a').attr('href',$(min).attr('rel'));
            });

            restaurant_photo_position = parseInt($(min).attr('pos'))-restaurant_photo_offset;
            if (restaurant_photo_position==restaurant_photo_visible &&
                restaurant_photo_position+restaurant_photo_offset<restaurant_photo_count) {
                restaurant_photo_offset++;
                show_pos = restaurant_photo_offset+restaurant_photo_visible;
                $('#restaurant_info .photos .mini[pos='+restaurant_photo_offset+']').animate({
                    'width':'hide'
                },200);
                $('#restaurant_info .photos .mini[pos='+show_pos+']').animate({
                    'width':'show'
                },200);
            } else if (restaurant_photo_position==1 &&
                restaurant_photo_offset>0) {
                restaurant_photo_offset--;
                show_pos = restaurant_photo_offset+1;
                hide_pos = restaurant_photo_offset+restaurant_photo_visible+1;
                $('#restaurant_info .photos .mini[pos='+hide_pos+']').animate({
                    'width':'hide'
                },200);
                $('#restaurant_info .photos .mini[pos='+show_pos+']').animate({
                    'width':'show'
                },200);
            }
        });
        // Нажатие на кнопку отзыв - минус
        $('.restaurant_header .rest_rating .minus').click(function(){
            update_rating_without_text(current_rest_id,-1);
        });
        // Нажатие на кнопку отзыв - плюс
        $('.restaurant_header .rest_rating .plus').click(function(){
            update_rating_without_text(current_rest_id,1);
        });
        $('.reviews .form input[type="submit"]').click(function(){
            text = $(this).parents('form').find('textarea').val();
            comment_rest(current_rest_id,text);
            return false;
        });
        // Показать карту google
        $('.map_link a').click(function(){
            $.showDialog('google_dialog');
            map_init();
            return false;
        });
    }
    /* ---------------------------------------------------------------------
    * Если находимся на странице вывода меню (авктивирован калькулятор)
    */
    if (typeof(calс_activate)!='undefined') {
        /*
        * Добавить блюдо в корзину
        */
        $('.add_trash_item').click(function(){
            itogo = 0;
            $parent = $(this).parents('.dish_item');
            dish = $parent.attr('id');
            if ($('#trash_'+dish).length) {
                cn = parseInt($('#trash_'+dish).find('.number').html());
                $('#trash_'+dish).find('.number').html(cn+1);
                price = $('#trash_'+dish).find('.price').html();
                price = parseInt((price/cn)*(cn+1));
                $('#trash_'+dish).find('.price').html(price);
                trash_itogo();
            } else {
                title = $parent.find('.title').html();
                price = $parent.find('.price span').html();
                $trash_item = $(
                    '<tr class="trash_item" id="trash_'+dish+'">'+
                    '<td class="title">'+title+'</td>'+
                    '<td class="count">'+
                    '<div class="number">1</div>'+
                    '<div class="actions">'+
                    '<div class="add">'+
                    '<img class="trash_add_item" src="/public/images/icons/small_add_icon.png"/>'+
                    '</div>'+
                    '<div class="remove">'+
                    '<img class="trash_remove_item" src="/public/images/icons/small_remove_icon.png"/>'+
                    '</div>'+
                    '</div>'+
                    '</td>'+
                    '<td class="price">'+price+'</td>'+
                    '</tr>'
                    );
                $('.trash .items table#list_trash').append($trash_item);
				
                $trash_item.find('.trash_add_item').click(function(){
					
                    cn = parseInt($(this).parents('.trash_item').find('.number').html());
                    $(this).parents('.trash_item').find('.number').html(cn+1);
                    price = $(this).parents('.trash_item').find('.price').html();
                    price = parseInt((price/cn)*(cn+1));
                    $(this).parents('.trash_item').find('.price').html(price);
                    trash_itogo();
				
					
                });
                $trash_item.find('.trash_remove_item').click(function(){
                    cn = parseInt($(this).parents('.trash_item').find('.number').html());
                    if (cn>1) {
                        $(this).parents('.trash_item').find('.number').html(cn-1);
                        price = $(this).parents('.trash_item').find('.price').html();
                        price = parseInt((price/cn)*(cn-1));
                        $(this).parents('.trash_item').find('.price').html(price);
                        trash_itogo();
                    } else {
                        $trash_item.remove();
                        trash_itogo();
                    }
                });
            }
        });
        /*
        * Удалить блюдо из корзины
        */
        $('.remove_trash_item').click(function(){
            $parent = $(this).parents('.dish_item_l');
            dish = $parent.attr('rel');
            if ($('#trash_'+dish).length) {
                cn = parseInt($('#trash_'+dish).find('.number').html());
                if (cn>1) {
                    $('#trash_'+dish).find('.number').html(cn-1);
                    price = $('#trash_'+dish).find('.price').html();
                    price = parseInt((price/cn)*(cn-1));
                    $('#trash_'+dish).find('.price').html(price);
                    trash_itogo();
                } else {
                    $('#trash_'+dish).remove();
                    trash_itogo();
                }
            }
        });
    }
    /* ---------------------------------------------------------------------
    * Если находимся на странице вывода лиц фудфуд
    */
    if (typeof(person_page_activate)!='undefined') {
        persons_check_buttons ();
        $('#persons_list .item').click(function(){
            $('#persons_list .item.current').removeClass('current');
            $(this).addClass('current');
            id = $(this).attr('rel');
            $('#person').html('');
            $('#person').append($loader);
            $('#person #loader').show();
            $.post('/'+site_city+'/persons/view/'+id,
                function (data) {
                    $('#person').html(data);
                    name = $('#person .name').html();
                    $('#person_name_caption').html(name);
                    $('.interview .quest').click(function(){
                        $('.interview .quest.active').removeClass('active');
                        $(this).addClass('active');
                        $('.interview .answer').hide();
                        $(this).parent('.int').find('.answer').show();
                    });
                });
            person_item_position = parseInt($(this).attr('pos'))-person_item_offset;
            if (person_item_position==person_item_visible &&
                person_item_position+person_item_offset<person_item_count) {
                if (person_item_offset+person_item_visible<person_item_count) {
                    person_item_offset++;
                    $("#persons_list").animate({
                        scrollLeft:Math.ceil(person_item_offset*75)
                    },300);
                }
                persons_check_buttons ();
                return false;
            } else if (person_item_position==1 && person_item_offset>0) {
                if (person_item_offset>0) {
                    person_item_offset--;
                    $("#persons_list").animate({
                        scrollLeft:Math.ceil(person_item_offset*75)
                    },300);
                }
                persons_check_buttons ();
            }
        });
        $.post('/'+site_city+'/persons/view/'+person_id,
            function (data) {
                $('#person').html(data);
                name = $('#person .name').html();
                $('#person_name_caption').html(name);
                $('.interview .quest').click(function(){
                    $('.interview .quest.active').removeClass('active');
                    $(this).addClass('active');
                    $('.interview .answer').hide();
                    $(this).parent('.int').find('.answer').show();
                });
            });
    }
    $('.select_percent div').click(function(){
        per = $(this).attr('class');
        if(per!='all'){
            $('.discount_list .item').hide();
            $('.discount_list .item:has(.'+per+')').show();
        } else {
            $('.discount_list .item').show();
        }
    });
    /* ---------------------------------------------------------------------
    * Если находимся на странице вывода афиш
    */
    if (typeof(poster_page_activate)!='undefined') {
        // Месяцы
        $("#mounth_list .back").click(function(){
            if (poster_month_position>0) {
                poster_month_position--;
                $("#mounth").animate({
                    scrollLeft: poster_month_position*150
                },250);
                get_poster ();
            }
        });
        $("#mounth_list .next").click(function(){
            if (poster_month_position<poster_month_count) {
                poster_month_position++;
                $("#mounth").animate({
                    scrollLeft: poster_month_position*150
                },250);
                get_poster ();
            }
        });
        poster_month_position = current_month+11;
        poster_month_count = $("#mounths_conteiner .item").length -1;
        $("#mounth").animate({
            scrollLeft: (current_month-1)*150+12*150
        },250);
        // Дни
        $('.date_list .item').click(function(){
            $('.date_list .item.current').removeClass('current');
            $(this).addClass('current');
            get_poster ();
        });
        $('#poster_follow').click(function(){
            if(user_auth!='1') {
                $.alert('Вы должны войти на сайт',true);
            } else {
                $.post('/'+site_city+'/poster/follow/',{
                    'poster':poster_id
                },function (data) {
                    if (data=='OK') $.alert('Приятного времяпровождения!',false);
                    else if (data=='NO_LOGIN') $.alert('Вы должны войти на сайт, чтобы оставлять отзывы',true);
                    else if (data=='ALREADY') $.alert('Приятного времяпровождения!',true);
                    else $.alert('Ошибка. Попробуйте еще раз',true);
                });
            }
            return false;
        });
        // получаем афишу на текущий день
        offset= current_day;
        if (offset<10) offset = '0'+offset;
        $('.date_list .item[offset="'+offset+'"]').click();
        // прокручиваем так, чтобы был виден текущий день
        if (current_day>poster_day_count) {
            poster_day_scroll = poster_day_count + 1;
        } else {
            poster_day_scroll = current_day;
        }
        poster_day_position = poster_day_scroll-1;
        $(".date_list .items").animate({
            scrollLeft: (poster_day_scroll - 1)*115
        },250);
        // нажатие на кнопки прокрутки дней
        $(".date_list .back").click(function(){
            if (poster_day_position>0) {
                poster_day_position--;
                $(".date_list .items").animate({
                    scrollLeft: poster_day_position*115
                },250);
            }
        });
        $(".date_list .next").click(function(){
            if (poster_day_position<poster_day_count) {
                poster_day_position++;
                $(".date_list .items").animate({
                    scrollLeft: poster_day_position*115
                },250);
            }
        });
    }

    /* ---------------------------------------------------------------------
    * Если находимся на странице вывода скидок
    */
    if (typeof(discount_page_activate)!='undefined') {
        $('.select_percent div').click(function(){
            per = $(this).attr('class');
            if(per!='all'){
                $('.discount_list .item').hide();
                $('.discount_list .item:has(.'+per+')').show();
            } else {
                $('.discount_list .item').show();
            }
        });
        // Нажатие на кнопку со скидкой
        $('.discount_list .item').click(function(){
            $('#discount_submit').attr('partner',$(this).attr('partner'));
            title = $(this).find('.name a').html();
            percent = $(this).attr('percent');
            description = $(this).find('.discount_description').html();
            $('#discount_dialog .name').html(title);
            $('#discount_dialog .description_discount').html(description);
            $('#discount_dialog .discount_percent .number').html(''+percent+' <span>%</span>');
            $.showDialog('discount_dialog');
            return false;
        });
        check_discount_anchor ();
    }
});

/*
 * Проверка и обработка ширины экрана
 */
function check_window_width () {
    mood_check_width ();
    by_mood_check_width ();
    if (typeof(person_page_activate)!='undefined')
        persons_check_width ();
    if (typeof(poster_page_activate)!='undefined')
        poster_day_check_width ();
}
/*
 * Обработка ширины блоков ресторанов при поиске
 */
function by_mood_check_width () {
    $('#restaurant_by_mood_content .item').css('display','none');
    by_mood_add_count=(Math.ceil(($(document).width()-10)/230)-1)*2;//340
    by_mood_visible = by_mood_add_count;
    by_mood_count = 0;
    by_mood_position = 0;
    counter=1;
    $('#restaurant_by_mood_content .item').each(function(){
        $(this).attr('id','by_mood_item_'+counter);
        counter = counter +1;
        if(by_mood_add_count>0) {
            $(this).animate({
                'width':'show'
            },100);
            by_mood_add_count--;
        }
        by_mood_count++;
    });
}
/*
 * Обработка ширины блоков лиц foodfood
 */
function persons_check_width () {
    person_item_visible=Math.ceil(($(document).width()-33)/75)-1;
    $('#persons_list').width(person_item_visible*75);
    person_item_count = $('#persons_list .item').length;
}
/*
 * Обработка ширины блоков лиц foodfood
 */
function poster_day_check_width () {
    poster_day_visible=Math.ceil(($(document).width() - 410)/115) - 1;
    $('.date_list .items').width(poster_day_visible*115);
}
/*
 * Обработка ширины блоков лиц foodfood
 */
function persons_check_buttons () {
    if (person_item_offset+person_item_visible<person_item_count){
        $('.restaurant_header .next').addClass('active');
    } else {
        $('.restaurant_header .next').removeClass('active');
    }
    if (person_item_offset>0){
        $('.restaurant_header .back').addClass('active');
    } else {
        $('.restaurant_header .back').removeClass('active');
    }
}
/*
 * Добавить комментарий ресторану
 */
function comment_rest(rest_id,text){
    if(user_auth!='1') {
        $.alert('Вы должны войти на сайт, чтобы оставлять отзывы',true);
    } else {
        $.post('/'+site_city+'/restaurant/comment/'+rest_id+'/' ,{
            'text':text,
            'target':0
        },function (data) {
            if (data=='OK') $.alert('Отзыв добавлен',false);
            else if (data=='NO_LOGIN') $.alert('Вы должны войти на сайт, чтобы оставлять отзывы',true);
            else if (data=='ALREADY') $.alert('Вы уже оставляли отзыв для данного ресторана',true);
            else if (data=='LENGTH') $.alert('Длина отзыва не должна превышать 500 символов',true);
            else if (data=='MAT') $.alert('Ваш отзыв не принят из-за мата',true);
            else if (data=='FMIN') $.alert('Вы не можете оставлять более 1 отзыва ресторану за 5 минут',true);
            else $.alert('Ошибка. Попробуйте еще раз',true);
        });
    }
}
function get_poster () {
    // Получаем афишу на выделенный день
    year = current_year - 1 + parseInt((poster_month_position / 12));
    month = (poster_month_position%12)+1;
    if (month<10) month='0'+month;
    day = $('.date_list .item.current').attr('offset');
    if ((parseInt(month) == parseInt(current_month)) && (parseInt(year) == parseInt(current_year))) {
        offset= current_day;
        if (offset<10) offset = '0'+offset;
        $('.date_list .item[offset="'+offset+'"]').attr("id","today").html('сегодня');
    } else {
        $('#today').html('<div>'+current_day+'<sup>'+current_week+'</sup></div>').attr("id","");
    }
    date=''+year+'.'+month+'.'+day;
    $('.anounce_block').html($loader);
    $.post('/'+site_city+'/poster/date/',{
        'date':date,
        'day':day,
        'month':month
    },function(data){
        $('.anounce_block').html(data);
    });
    // Вычисляем сколько дней в этом месяце
    if (month == 2 && year % 4 == 0) {
        poster_day_count = 29;
    } else if (month == 2) {
        poster_day_count = 28;
    } else if ((month <= 7 && month % 2 == 1) || (month > 7 && month % 2 == 0)) {
        poster_day_count = 31;
    } else {
        poster_day_count = 30;
    }
    poster_day_count = poster_day_count - poster_day_visible;
    // прокручиваем так, чтобы был виден текущий день
    if (poster_day_position>poster_day_count) {
        poster_day_position = poster_day_count;
        $(".date_list .items").animate({
        scrollLeft: (poster_day_position)*115
    },250);
    }
    // заменяем дни недели на кнопках 
    $(".date_list .item").each(function(){
        el_date_str = (month + '/'+$(this).attr('offset')+'/'+year);
        el_date = new Date(Date.parse(el_date_str));
        $(this).find('sup').html(week_days[el_date.getDay()]);
    });
    return false;
}
function trash_itogo() {
    itogo = 0;
    $("#list_trash td.price").each(function(){
        item_price = parseInt($(this).html());
        itogo = itogo+item_price;
    });
    $("#priceItogo").html(itogo);
}
function check_discount_anchor () {
    anchor = get_anchor ();
    if (anchor.match(/get-.*/i)) {
        current_discount = anchor.replace(/get-/,'');
        $('.discount_list .item[partner="'+current_discount+'"]').click();
    }
}