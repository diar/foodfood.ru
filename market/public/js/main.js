
// Выполнение после загрузки на всех страницах
$(document).ready(function () {

		$("#size_price input").click (function(){
		   	preparePrice ();			
		});
		
		$("#present").change(function () {
			preparePrice ();
		});
		//При изменении количевста
		$("#count").keyup(function () {
			preparePrice ();
		});
		//Добавление в корзину    
        $("#order").click(function(){
            portion = $("#size_price input:checked").attr('alt');
            item_id = $("#item_id").val();
            price = $("#size_price input:checked").val();
            title = $('#title').html();
			count = $('#count').val();
			is_present = $('#present:checked').val();
            $.post('/product/trashAdd/',
            {
                'item_id':item_id,
                'price':price,
                'title':title,
                'size':portion,
                'count':count,
				'is_present':is_present
            },function(data){
                //$("#trash_gen_price").html(data);
            });
            return false;
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
	count = parseInt($("#count").val());
	if (isNaN(count)) count = 1;
	return count;	
}

function getOldPrice () {
	old_price = parseInt($("#size_price input:checked").attr('rel'));
	if (isNaN(old_price)) return false;
	return old_price;
}

function getPrice () {
	price = parseInt($("#size_price input:checked").val());
	return price;
}

function isPresent () {
	if ($("#present").attr('checked')) {
		return true;
	}
	else return false;
}


function preparePrice () {
	p_count = getCount();
	p_price = getPrice()*p_count;
	p_present = isPresent();
	if (getOldPrice () > 0) {
		p_old_price = getOldPrice ()*p_count;
		if (p_present) p_old_price = p_old_price + 200;
		$("#old_price").html(p_old_price);
	}
	
	if (p_present) p_price = p_price+200; 
	$("#price").html(p_price);
}