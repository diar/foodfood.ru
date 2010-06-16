//----------------- Страница скидок ----------
discount_input = new Array ();

$(window).resize(function(){
    l_width = 130 - 1220 + $(document).width();
    if (l_width<10) l_width=10;
    $('#discount_content').css({
        'paddingLeft':l_width
    });
});

$.showMessage = function (str) {
    $('#discount_message_close').click (function(){
        $.hideMessage();
    });
    doc_width=$(document).width();
    el_width=$('#discount_message').width();
    el_height=$('#discount_message').height();
    left = doc_width/2 - el_width/2;
    $('#discount_message').css({
        'left':left,
        'top':200
    });
    $('#discount_message_border').css({
        'left':left-10,
        'top':200-10,
        'width':el_width+20,
        'height':el_height+20
    });
    $('#discount_message_window').html(str);
    $('#discount_message').fadeIn(500);
    $('#discount_message_border').fadeIn(500);
};

$.hideMessage = function () {
    $('#discount_message').fadeOut(500);
    $('#discount_message_border').fadeOut(500);
};

$.showLoader = function () {
    left=$(document).width()/2-24;
    $('#discount_loader').css({
        'left':left
    });
    $('#discount_loader').show(200);
};
$.hideLoader = function () {
    $('#discount_loader').hide(200);
}

$(document).ready(function () {
    if(!$.browser.msie) {
        $('.corner').corner('round 6px');
        $('.corner_top').corner('top round 6px');
        $('.corner_bottom').corner('bottom round 6px');
    }
    $('#discount_submit').click(function(){
        name = $('#discount_name').val();
        phone = $('#discount_phone').val();
        email = $('#discount_email').val();
        $.post('/'+site_city+'/discount/get/'+partner_id+'/',{
            'name':name,
            'phone':phone,
            'email':email
        }, function (data) {
            $.hideLoader();
            $.showMessage(data);
        });
    });
    $('.discount_input').click(function(){
        if (discount_input[this.id] == undefined)
            discount_input[this.id] = $(this).val();
        if ($(this).val()==discount_input[this.id]) {
            $(this).val('');
        }
    });
    $('.discount_input').blur(function(){
        if ($(this).val()=='')
            $(this).val(discount_input[this.id]);
    });
    $("#selectMenu a#currentOption").click(function() {
        if ($("#options").css('display') == 'none') {
            $("#options").animate({
                'height':'show',
                'opacity':'show'
            },300);
            $("#selectMenu a#currentOption").css({
                'color':'white',
                'background':'#93d124',
                'text-decoration':'none'
            });
        }
        else {
            $("#options").animate({
                'height':'hide',
                'opacity':'hide'
            },300);
            $("#selectMenu a#currentOption").css({
                'color':'#da640c',
                'background':'none',
                'text-decoration':'underline'
            });
        }
        return false;
    });
});

