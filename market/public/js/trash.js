
// Выполнение после загрузки на всех страницах
$(document).ready(function () {

		
		$(".present").change(function () {
			el = $(this).parent().parent();
			preparePrice (el);
			prepareItog();
		});

		$(".count").keyup(function () {
			el = $(this).parent().parent();
			preparePrice (el);
			prepareItog();
		});
 
    
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



function getCount () {
	count = parseInt($(".count",el).val());
	if (isNaN(count)) count = 1;
	return count;	
}


function getPrice (el) {
	price = parseInt($(".price_per_one",el).html());
	return price;
}

function isPresent () {
	if ($(".present",el).attr('checked')) {
		return true;
	}
	else return false;
}


function preparePrice (el) {

	p_count = getCount(el);
	p_price = getPrice(el)*p_count;
	p_present = isPresent(el);
		
	if (p_present) p_price = p_price+200; 
	$(".gen_price",el).html(p_price);
}

function prepareItog() {
	var itog = 0;
	$(".gen_price").each(function(){
			itog += parseInt($(this).html());
		});
	$("#itog").html(itog);
}