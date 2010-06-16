/* ---------------------------------------------------------------------
 * В этом файле обрабатывается поиск по настроению, алфавиту и т.д
 */
var scroll_bar_width = 0; // невидимая часть панели
var scroll_x1 = 0; // позиция X при нажатии
var scroll_offset = 0; // значение, на которое в данный момент передвинут скролл
var scroll_offtemp = 0; // временная переменная
var scroll_act = false; // нажата ли в данный момент кнопка мыши
var scroll_auto_left = false; // в какую сторону делать автоскролл
var scroll_mouse_over = false;
var scroll_stop = false;
var el_width = 0; // высота одного элемента в панели
var scroll_right = 0;
var search_by = "search_by_rest";
var search_offset = 0;
var search_page_count = 0;
var current_search = 'moods';
var current_mood = '';
var current_text = '';
var current_char = '';
var current_tags = Array();
var tags_disable = false;
$(document).ready(function(){
    /* -----------------------------------------------------------------
     * Изменить метод поиска
     */
    $('#show_search').click(function(){
        $('#moods_container, #chars_container, #random_container, #all_container').animate({
            'height':'hide'
        },200);
        $('#search_container').animate({
            'height':'show'
        },200);
        $('#restaurant_by_mood').animate({
            'height':'hide'
        },400);
        $('#additional, #restaurant, #footer').show();
        current_search = 'search';
    });
    $('#show_chars').click(function(){
        $('#moods_container, #search_container, #random_container, #all_container').animate({
            'height':'hide'
        },200);
        $('#chars_container').animate({
            'height':'show'
        },200);
        $('#chars .item.current.rounded').removeClass('current').removeClass('rounded');
        $('#restaurant_by_mood').animate({
            'height':'hide'
        },400);
        $('#additional, #restaurant, #footer').show();
        current_search = 'chars';
    });
    $('#show_moods').click(function(){
        $('#chars_container, #search_container, #random_container, #all_container').animate({
            'height':'hide'
        },200);
        $('#moods_container').animate({
            'height':'show'
        },200);
        $('#moods .icon').removeClass('active');
        $('#restaurant_by_mood').animate({
            'height':'hide'
        },400);
        $('#additional, #restaurant, #footer').show();
        current_search = 'moods';
    });
    $('#show_random').click(function(){
        $('#chars_container, #search_container, #moods_container, #all_container').animate({
            'height':'hide'
        },200);
        $('#random_container').animate({
            'height':'show'
        },200);
        $('#restaurant_by_mood').animate({
            'height':'show'
        },400);
        $('#additional, #restaurant, #footer').hide();
        $('.restaurant_navigate .caption').html('Случайные рестораны');
        current_search = 'random';
        search_start();
    });
    $('#show_all').click(function(){
        $('#chars_container, #search_container, #moods_container, #random_container').animate({
            'height':'hide'
        },200);
        $('#all_container').animate({
            'height':'show'
        },200);
        $('#restaurant_by_mood').animate({
            'height':'show'
        },400);
        $('#additional, #restaurant, #footer').hide();
        $('.restaurant_navigate .caption').html('Все рестораны');
        current_search = 'all';
        search_start();
    });
    /*
     * Нажатие на иконку настроения
     */
    $("#moods .icon").click(function(){
        if (!$(this).hasClass('active')) {
            current_mood = $(this).attr('uri');
            $('#moods .icon.active').removeClass('active');
            set_anchor ('mood-'+current_mood);
            $(this).addClass('active');
            $('.restaurant_navigate .caption').html('Настроение : '+$(this).find('.caption').html());
            search_offset = 0;
            search_start();
        } else {
            $(this).removeClass('active');
            remove_anchor ();
            $('#restaurant_by_mood').animate({
                'height':'hide'
            },400);
            $('#additional, #restaurant, #footer').show();
        }
    });
    /*
     * Нажатие на букву при поиске по алфавиту
     */
    $("#chars .item").click(function(){
        if (!$(this).hasClass('current')) {
            current_char = $(this).html();
            $('#chars .item.current.rounded').removeClass('current').removeClass('rounded');
            $(this).addClass('current').addClass('rounded');
            set_anchor ('char-'+current_char);
            $('.restaurant_navigate .caption').html('Поиск по букве : '+current_char);
            search_offset = 0;
            search_start();
        } else {
            $(this).removeClass('current').removeClass('rounded');
            $('#restaurant_by_mood').animate({
                'height':'hide'
            },400);
            $('#additional, #restaurant, #footer').show();
        }
    });
    /*
     * Выбор типа поиска (по кухне, музыке)
     */
    $("#search_types a").click(function(){
        $("#search_types a.active").removeClass('active');
        $(this).addClass('active');
        search_by = $(this).attr('id');
    });
    /*
     * Поиск по тексту
     */
    $('#search_form  .button').click(function(){
        $('.restaurant_navigate .caption').html('Результаты поиска : '+$('#search_text').val());
        current_text = $('#search_text').val();
        search_start();
    });
    /*
     * Обработка событий панели настроений
     */
    $('#cursor').mousedown(function(e){
        e = jQuery.event.fix(e);
        scroll_act = true;
        scroll_x1 = e.pageX;
    });
    $(document).mouseup(function(){
        if (scroll_act) {
            scroll_act = false;
            scroll_offset = scroll_offtemp;
        }
    });
    $("#moods").mouseenter(function(){
        scroll_mouse_over = true;
    });
    $("#moods").mouseleave(function(){
        scroll_mouse_over = false;
    });
    /*
     * Делаем правую надпись полупрозрачной
     */
    $('#cursor_top .right_text').css('opacity','0.5');
    /*
     * Прокрутка панели настроений при перемещении
     */
    $(document).mousemove(function(e){
        if (scroll_act) {
            scroll_offtemp =e.pageX - scroll_x1+scroll_offset;
            if (scroll_offtemp<0) scroll_offtemp = 0;
            if (scroll_offtemp>scroll_right) scroll_offtemp=scroll_right;
            $("#cursor").css({
                marginLeft:Math.ceil(scroll_offtemp)
            });
            $("#bar_top").scrollLeft(Math.ceil(scroll_offtemp * prop));

            check_opacity_text ();

            return false;
        }
    });
    /*
     * Прокрутка панели настроений по щелчку
     */
    $("#cursor_top").mousedown(function(e){
        if (!scroll_act) {
            scroll_offset = e.pageX - $("#cursor_top").offset().left - ($("#cursor").width()/2);
            if (scroll_offset<0) scroll_offset = 0;
            if (scroll_offset>scroll_right) scroll_offset=scroll_right;
            $("#cursor").animate({
                marginLeft:Math.ceil(scroll_offset)
            },300);
            $("#bar_top").animate({
                scrollLeft:Math.ceil(scroll_offset * prop)
            },300);
            scroll_offset = Math.ceil(scroll_offset);
            check_opacity_text_2 ();
            //$("#bar_top").scrollLeft(Math.ceil(scroll_offset * prop));
        }
    });
    /*
     * Обработка прокрутки мыши
     */
    $(document).mousewheel(function(event, delta){
        // Прокрутка над панелью настроений
        if (scroll_mouse_over && !scroll_stop) {
            scroll_last = scroll_offset;
            if (delta > 0) {
                scroll_offset = scroll_offset - 2*(el_width/prop);
            }
            else {
                scroll_offset = scroll_offset + 2*(el_width/prop);
            }
            if (scroll_offset<0) {
                scroll_offset = 0;
            }
            if (scroll_offset>scroll_right) {
                scroll_offset=scroll_right;
            }
            if (scroll_last != scroll_offset) {
                scroll_stop = true;
                $("#cursor").animate({
                    marginLeft:Math.ceil(scroll_offset)
                },600);
                $("#bar_top").animate({
                    scrollLeft:Math.ceil(scroll_offset*prop)
                },600,function(){
                    scroll_stop = false;
                });
                check_opacity_text_2 ();
            }
        }
        // Прокрутка над остальной частью страницы
        else if (!scroll_mouse_over) {
            return true;
        }
        return false;
    });
    /*
     * Нажатие на иконку тэга
     */
    $('#restaurant_by_mood .restaurant_tags .item').click(function(){
        if (tags_disable) return false;
        tags_disable = true;
        search_offset = 0;
        if (!$(this).hasClass('current')) {
            $(this).addClass('current');
        } else {
            $(this).removeClass('current');
        }
        current_tags = Array();
        i = 0;
        $('#restaurant_by_mood .restaurant_tags .item.current').each(function(){
            current_tags[i]=$(this).attr('tag');
            i++;
        });
        current_tags = serialize (current_tags);
        search_offset = 0;
        search_start();
    });
    /*
     * Нажатие на кнопку следующие
     */
    $('#restaurant_by_mood .restaurant_navigate .next').click(function(){
        if (search_page_count>search_offset+1) {
            search_offset++;
            search_start();
        }
    });
    /*
     * Нажатие на кнопку следующие
     */
    $('#restaurant_by_mood .restaurant_navigate .back').click(function(){
        if (search_offset>0){
            search_offset--;
            search_start();
        }
    });
});
/*
 * Начать поиск
 */
function search_start() {
    $('.restaurant_navigate .page_current').html(search_offset+1);
    $('.restaurant_navigate .page_count').html(search_page_count);
    $('#restaurant_by_mood_content').html('');
    $('#restaurant_by_mood_content').append($loader);
    $('#restaurant_by_mood_content #loader').show();
    $('#restaurant_by_mood').animate({
        'height':'show'
    },400);
    switch (current_search) {
        case 'moods' :
            select_by_mood();
            break;
        case 'chars' :
            select_by_char();
            break;
        case 'search' :
            select_by_text();
            break;
        case 'random' :
            select_by_rand();
            break;
        case 'all' :
            select_all();
            break;
    }
}
function search_after (data) {
    if (data!='') {
        $('#restaurant_by_mood_content').html(data);
    } else {
        message = '<div style="text-align:center;width:100%;">'+
                    'Мы ничего не нашли для тебя, попробуй ввести запрос по другому'+
                    '</div>'+
                '<div style="font-size:12px;color:#999999; font-style:italic;padding-top:20px; text-align:center;width:100%">'+
                'Все рестораны и кафе на фудфуде в русской транслитерации<br />'+
                'Джокер,а не Joker</div>';
        $('#restaurant_by_mood_content').html(message);
    }
    search_page_count = parseInt($('#restaurant_by_mood_content .page_count').html());
    $('.restaurant_navigate .page_count').html(search_page_count);
    if (search_page_count>search_offset+1) {
        $('#restaurant_by_mood .restaurant_navigate .next').addClass('active');
    } else {
        $('#restaurant_by_mood .restaurant_navigate .next').removeClass('active');
    }
    if (search_offset>0) {
        $('#restaurant_by_mood .restaurant_navigate .back').addClass('active');
    } else {
        $('#restaurant_by_mood .restaurant_navigate .back').removeClass('active');
    }
    tags_disable = false;
}
/*
 * Получить рестораны все рестораны
 */
function select_all() {
    // Получение страницы по ajax
    $.post('/'+site_city+'/index/all/',{
        'width':$(document).width(),
        'tags':current_tags,
        'offset':search_offset
    }, function (data) {
        search_after (data);
    });
    $('#additional, #restaurant, #footer').hide();
}
/*
 * Получить рестораны по настроению
 */
function select_by_mood () {
    // Получение страницы по ajax
    $.post('/'+site_city+'/index/mood/',{
        'width':$(document).width(),
        'mood':current_mood,
        'tags':current_tags,
        'offset':search_offset
    }, function (data) {
        search_after (data);
    });
    $('#additional, #restaurant, #footer').hide();
}
/*
 * Получить рестораны по букве
 */
function select_by_char () {
    // Получение страницы по ajax
    $.post('/'+site_city+'/index/char/',{
        'width':$(document).width(),
        'char':current_char,
        'tags':current_tags,
        'offset':search_offset
    }, function (data) {
        search_after (data);
    });
    $('#additional, #restaurant, #footer').hide();
}
/*
 * Получить рестораны по настроению
 */
function select_by_text () {
    // Получение страницы по ajax
    $.post('/'+site_city+'/index/search/',{
        'width':$(document).width(),
        'search_by':search_by,
        'text':current_text,
        'tags':current_tags,
        'offset':search_offset
    }, function (data) {
        search_after (data);
    });
    $('#additional, #restaurant, #footer').hide();
}
/*
 * Получить случайные
 */
function select_by_rand () {
    $.post('/'+site_city+'/index/random/',{
        'width':$(document).width(),
        'tags':current_tags,
        'offset':search_offset
    }, function (data) {
        search_after (data);
    });
    $('#additional, #restaurant, #footer').hide();
}
/*
 * Обработка ширины блоков настроений
 */
function mood_check_width () {
    var alt = 0 ;
    $("#bar_top").scrollLeft(0);
    $("#cursor").css('marginLeft',0);
    $('#bar .icon').each(function(){
        padding = parseInt($(this).css('paddingLeft')) + parseInt($(this).css('paddingRight'))
        margin = parseInt($(this).css('marginLeft')) + parseInt($(this).css('marginRight'));
        border = 2; //Ширина border
        alt = alt + $(this).width() + padding + margin + border;
        el_width = $(this).width() + parseInt($(this).css('paddingLeft'));
    });
    bar_width = $("#bar_top").width();
    scroll_cursor_width=bar_width / (alt/bar_width);
    $('#cursor').width(scroll_cursor_width);
    scroll_right = $('#cursor_top').width()-$('#cursor').width()-5;
    alt = alt - $("#bar_top").width();
    if (alt>0) {
        $('#cursor_top').show();
    } else {
        $('#cursor_top').hide();
    }
    scroll_bar_width = alt;
    prop = scroll_bar_width / scroll_right;
}

function check_opacity_text () {
    crt=((scroll_right-scroll_offtemp)/scroll_right*100)/100+0.5;
    if (crt>1) crt=1;
    clt=1.5 - crt;
    $('#cursor_top .left_text').css('opacity',crt);
    $('#cursor_top .right_text').css('opacity',clt);
}
function check_opacity_text_2 () {
    crt=((scroll_right-scroll_offset)/scroll_right*100)/100+0.5;
    if (crt>1) crt=1;
    clt=1.5 - crt;
    $('#cursor_top .left_text').css('opacity',crt);
    $('#cursor_top .right_text').css('opacity',clt);
}