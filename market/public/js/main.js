var current_menu_type_id = 0;
var tags_disable = false;
var current_tags = '';
var current_location = 1;

var dish_photo_count = 0;
var dish_photo_visible = 6;
var dish_photo_offset = 0;
var dish_photo_position = 0;
// Выполнение после загрузки на всех страницах
$(document).ready(function () {

    // Выбор локации
    $('.first_col .select').click( function(){
        $('#locate_select').click();
    });
    $('#locate_select').change( function(){
        $('.first_col .select').html($(this).find(':selected').html());
        search_start();
        change_location_remember ();
    });

    $('#locate_select option:selected').each(function(){
        $('.first_col div.select').html($(this).html());
    });

    $('#remember_location').click(function(){
        change_location_remember ();
    });

    // Выбор типа меню
    $('#menu_types li').click(function(){
        $('#menu_types li.active').removeClass('active');
        $(this).addClass('active');
        current_menu_type_id = $(this).attr('id');
        search_start();
        return false;
    });
    // Выбираем первый тип меню
    $('#menu_types li').first().click();

    /* ---------------------------------------------------------------------
     * Если находимся на странице вывода блюда
     */
    if (typeof(dish_page_activate)!='undefined') {
        $("#review_textarea").keyup(function(){

            var length = $(this).val().length;

            $("#reviews_comment_lenght").html(length);
            if (length > 2000) return false;
        });

        $('.main_container a').lightBox({
            imageLoading: '/public/js/libs/lightbox/images/lightbox-ico-loading.gif',
            imageBtnClose:'/public/js/libs/lightbox/images/lightbox-btn-close.gif',
            imageBtnPrev: '/public/js/libs/lightbox/images/lightbox-btn-prev.gif',
            imageBtnNext: '/public/js/libs/lightbox/images/lightbox-btn-next.gif',
            imageBlank:   '/public/js/libs/lightbox/images/lightbox-blank.gif',
            fixedNavigation:true
        });
        $('#dish_info .photos .main').first().show().addClass('current');
        /*
         * Инициализация превью фоток
         */
        $('#dish_info .photos .mini').each(function(){
            dish_photo_count++;
            if (dish_photo_count<=dish_photo_visible) {
                $(this).show();
            }
            $(this).attr('pos',dish_photo_count);
        });
        /*
         * Нажатие на превью фотки ресторана
         */
        $('#dish_info .photos .mini').click(function(){
            min = this;
            $('#dish_info .photos .mini.active').removeClass('active');
            $(min).addClass('active');
            $('#dish_info .photos .main.current').removeClass('current').fadeOut(300,function(){
                $('#dish_info .photos .main[src="'+$(min).attr('rel')+'"]').fadeIn(300).addClass('current');
                $('#dish_info .photos .main[src="'+$(min).attr('rel')+'"] a').attr('href',$(min).attr('rel'));
            });
            dish_photo_position = parseInt($(min).attr('pos'))-dish_photo_offset;
            if (dish_photo_position==dish_photo_visible &&
                dish_photo_position+dish_photo_offset<dish_photo_count) {
                dish_photo_offset++;
                show_pos = dish_photo_offset+dish_photo_visible;
                $('#dish_info .photos .mini[pos='+dish_photo_offset+']').animate({
                    'width':'hide'
                },200);
                $('#dish_info .photos .mini[pos='+show_pos+']').animate({
                    'width':'show'
                },200);
            } else if (dish_photo_position==1 &&
                dish_photo_offset>0) {
                dish_photo_offset--;
                show_pos = dish_photo_offset+1;
                hide_pos = dish_photo_offset+dish_photo_visible+1;
                $('#dish_info .photos .mini[pos='+hide_pos+']').animate({
                    'width':'hide'
                },200);
                $('#dish_info .photos .mini[pos='+show_pos+']').animate({
                    'width':'show'
                },200);
            }
        });
        // Ставим цену в зависимости от порции

        current_portion = $('#portions input[checked=checked]').val();
        $('#price_text').html($('#portions input[checked=checked]').attr('rel'));
        $('#to_trash_portion').html(current_portion);
        $('#portions input').click(function(){
            $('#price_text').html( $(this).attr('rel'));
            $('#to_trash_portion').html($(this).val());
        });
        $("#to_trash").click(function(){
            portion = $("#to_trash_portion").html();
            dish_id = $("#to_trash_dish_id").html();
            price = $('#price_text').html();
            title = $('h1.title').html();
            rest_id = $('#to_trash_rest_id').html();
            $.post('/market/'+site_city+'/index/add/',
            {
                'dish_id':dish_id,
                'price':price,
                'title':title,
                'portion':portion,
                'rest_id':rest_id
            },function(data){
                $('.trash .order').show();
                $('.trash_description').html(data);
                $('.trash .rub').html(
                    $('.trash_description .price').html()+'<sup> руб.</sup>'
                    );
            });
            return false;
        });
    }
});

function search_start() {
    current_location = $('#locate_select').val();
    $.post('/market/'+site_city+'/index/menu/',{
        'menu_type_id':current_menu_type_id,
        'menu_tags':current_tags,
        'location':current_location
    },function(data){
        $('#menu_list').html(data);
        tags_disable = false;
        actions_create();
        $('.portion').click(function(){
            $(this).parents('.portions').find('.portion').removeClass('active');
            $(this).addClass('active');
            price = $(this).attr('rel');
            price = '<span>'+price+'</span> руб.';
            $(this).parents('.item').find('.new').html(price);
        });
    });
    
};

function actions_create() {
    // Нажатие на тэг
    $('#menu_list .menu_tag').click(function(){
        if (tags_disable) return false;
        tags_disable = true;
        if (!$(this).hasClass('current')) {
            $(this).addClass('current');
        } else {
            $(this).removeClass('current');
        }
        tags = Array();
        i = 0;
        $('#menu_list .menu_tag.current').each(function(){
            tags[i]=$(this).attr('tag');
            i++;
        });
        current_tags = serialize (tags);
        search_start();
    });

    // Кнопка заказать
    $('.get .buy').click(function(){
        price = parseInt ($(this).parents('.item').find('.price .new span').html());
        portion = parseInt ($(this).parents('.item').find('.portion.active').html());
        dish_id = $(this).parents('.item').attr('id').replace('dish_','');
        rest_id = $(this).parents('.item').attr('rest_id');
        title = $(this).parents('.item').find('.title a').html();
        $.post('/market/'+site_city+'/index/add/',
        {
            'dish_id':dish_id,
            'price':price,
            'title':title,
            'portion':portion,
            'rest_id':rest_id
        },function(data){
            $('.trash .order').show();
            $('.trash_description').html(data);
            $('.trash .rub').html(
                $('.trash_description .price').html()+'<sup> руб.</sup>'
                );
        });
    });
}

/*
 * Добавить комментарий к блюду
 */
function comment_dish(rest_id,text,to_admin){
    return false;
    if(user_auth!='1') {
        $.alert('Вы должны войти на сайт, чтобы оставлять отзывы',true);
    } else {
        $.post('/'+site_city+'/restaurant/comment/'+rest_id+'/' ,{
            'text':text,
            'to_admin':to_admin,
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


function change_location_remember () {
    current_location = $('#locate_select').val();
    $.post('/market/'+site_city+'/index/set_location/',{
        'location':current_location,
        'remember':$('#remember_location').attr('checked')
    });
}