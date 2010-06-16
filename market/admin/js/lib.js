function in_array(what, where) {
    var a=false;
    for(var i=0; i<where.length; i++) {
        if(what == where[i]) {
            a=true;
            break;
        }
    }
    return a;
}

function getModuleLink () {
	var locationHref = location.href;
	var moduleHrefLastIndex = location.href.indexOf("&");
	var moduleHref = locationHref.substr(0,moduleHrefLastIndex);
	return moduleHref;	
}


$.fn.replaceInput = function () {
	var inputs = $("input:not(.no_replace)");
	$("input[type=file]").css('opacity',0);
	var z = 1;
	inputs.each(function() {
		var input = $(this);
		var type = input.attr('type');
		var text_id = 'text_file_'+z;
		var div_file_id = "div_file_"+z;
		var fakeInput = ' ';
		if (type == 'file') var fakeInput = '<div id="'+text_id+'" class="fakeFileInput" ></div>';
		var repHtml = '<div class="input '+type+'" id="'+div_file_id+'">'+fakeInput+'</div>';
		input.before(repHtml).remove();
		$("#"+div_file_id).append(input);
		
		if (type == 'file') {
			input.change(function(){
				$("#"+text_id).empty();
				$("#"+text_id).append(input.val());
			});
		}
		z++;
	});	
}

$.fn.replaceTextarea = function () {
	var textareas = $("textarea[rel=textarea]");
	var z = 1;
	textareas.each(function() {
		var textarea = $(this);
		var div_textarea_id = "div_textarea_"+z;
		var repHtml = '<div class="textarea" id="'+div_textarea_id+'"></div>';
		textarea.before(repHtml).remove();
		$("#"+div_textarea_id).append(textarea);
		
		z++;
	});	
}


