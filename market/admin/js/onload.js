$(document).ready(
    function() {

	$('.add_to_tree').live('click',function(){
		level = parseInt($(this).attr('rel'));
		new_el = '<li rel='+level+'><input type="text" name="title" maxlength="150" size="10" id="input_el_title" /> <input type="button" value="ok" id="add_to_tree_el"/></li>'
		if (level == 0) $('#tree_menu').append(new_el);
		else $('li[rel='+level+'] ul:last',$('#tree_menu')).append(new_el);
		$('#tree_menu input').focus();
		return false;
	});
	
	$('.add_line').live('click',function(){
		add_line();
		set_line_function ();
	});
	
	$('.del_line').live('click',function(){
		$(this).parent().parent().remove();
		set_line_function ();
	});
	
	$("#add_to_tree_el").live('click',function(){
		title = $('#input_el_title').val();
		parent_id = $(this).parent().attr('rel');
		$.post('/admin/admin.php?page=product&action=addToTree',{
			'title':title,
			'parent_id':parent_id
			},function(data){
				if (data =='') {
					alert('Неудача.');
				} else {
					ul = $("#add_to_tree_el").parent().parent();
					$("#add_to_tree_el").parent().remove();
					ul.append('<li rel="'+data+'"><a href="#">'+title+'</a><a href="#" class="add_to_tree" rel="'+data+'"><img src="images/1.jpg" alt="Добавить раздел" /><a href="admin.php?page=product&action=add&parent_id='+data+'"><img src="images/add_product.jpg" alt="Добавить раздел" /></li>');
				}
		});
		
	});
});

function add_line(){
	newline = '<tr><td><input type="text" name="size[]" /></td><td><input type="text" name="price[]" /></td><td><div class="function_line add_line">+</div></td></tr>';
	$('#size_price').append(newline);
	set_line_function ();
}



function set_line_function (){
	$('tr td div', $('#size_price')).html('-').attr('class','function_line del_line');
	$('tr td:last div', $('#size_price')).html('+').attr('class','function_line add_line');
}


