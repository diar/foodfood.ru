var current_menu_type_id = 0;
var tags_disable = false;
var current_tags = '';
// Выполнение после загрузки на всех страницах
$(document).ready(function () {
    // Выбор локации
    $('.first_col .select').click( function(){
        $('#locate_select').click();
    });
    $('#locate_select').change( function(){
        $('.first_col .select').html($(this).find(':selected').html());
    });

    // Выбор типа меню
    $('.navigation .menu li').click(function(){
        $('.navigation .menu li.active').removeClass('active');
        $(this).addClass('active');
        current_menu_type_id = $(this).attr('id');
        search_start();
    });
    // Выбираем первый тип меню
    $('.navigation .menu li').first().click();
});

function search_start() {
    $.post('/market/'+site_city+'/index/menu/',{
        'menu_type_id':current_menu_type_id,
        'menu_tags':current_tags
    },function(data){
        $('#menu_list').html(data);
        tags_disable = false;
        actions_create();
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
        price = parseInt ($(this).parents('.item').find('.price .new').html());
        dish_id = $(this).parents('.item').attr('id').replace('dish_','');
        rest_id = $(this).parents('.item').attr('rest_id');
        title = $(this).parents('.item').find('.title a').html();
        $.post('/market/'+site_city+'/index/add/',
        {
            'dish_id':dish_id,
            'price':price,
            'title':title,
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