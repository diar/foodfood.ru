//----------------- Системные функции ----------
$loader = '<div class="loader"><img src="/public/images/loader.gif" alt="Загрузка..." /></div>';
$loader_gray = '<div class="loader"><img src="/public/images/loader_gray.gif" alt="Загрузка..." /></div>';

// Показать диалог
$.showDialog = function (id) {
    $body_fill = $('#body_fill');
    // Показываем затемнение
    if ($('#body_fill').length==0) {
        $body_fill = $('<div id="body_fill"></div>');
        $('body').append($body_fill);
    }
    $body_fill.css('opacity',0).show().animate({
        'opacity':0.5
    },300);
    // Показываем диалог
    $('#'+id).css('top',100);
    $('.dialog:not(#'+id+')').fadeOut(300,function(){
        $('#'+id).fadeIn(300);
    });
};

// Показать диалог, содержимое которого загружается через ajax
$.showAjaxDialog = function (url,height,params,func) {
    $('#empty_dialog').css('height',height).find('.content').html($loader).find('.loader').css('marginTop',150);
    $.showDialog('empty_dialog');
    $.post(url,params, function(data){
        $('#empty_dialog .content').html(data);
        func();
    });
};

// Показать диалог
$.hideDialog = function (id) {
    $('#body_fill').animate({
        'opacity':0
    },300).hide();
    $('#'+id).fadeOut(300);
};

// Изменить диалог
$.toggleDialog = function (id) {
    // Показываем диалог
    $('#'+id).css('top',100);
    $('.dialog:not(#'+id+')').fadeOut(300,function(){
        $('#'+id).fadeIn(300);
    });
};

// Показать сообщение
$.alert = function (message,error) {
    if (typeof(alert_timeout)!='undefined') clearTimeout(alert_timeout);
    alert_timeout = setTimeout('$.hideDialog ("message_dialog")', 5000);
    if(!$.browser.msie) {
        scroll=$(document).scrollTop();
        $('#message_dialog').css('top',scroll);
    }
    if (error)  {
        $('#message_dialog').css({
            'background':'#D84705',
            'opacity':'0.9',
            'color':'#fff'
        });
    } else {
        $('#message_dialog').css({
            'background':'#489615',
            'opacity':'0.9',
            'color':'#fff'
        });
    }
    $('#message_dialog').css({
        'marginTop':'-500px'
    }).show();
    $('#message_dialog').animate({
        'marginTop':'0'
    },1000);
    $('#message_dialog .text').html(message);

};

// Выполнение после загрузки на всех страницах
$(document).ready(function () {
    apply_styles ();
    $('input[type="text"],input[type="password"]').keyboard('enter',function(){
        $(this).parents('.ajax_form').find('input[type="button"]').click();
        return false;
    });
    // Нажатие на кнопку авторизации или регистрации
    $('#login_block #login').click(function(){
        $('#auth_message').html('');
        $.showDialog('auth_dialog');
        return false;
    });
    $('#login_block #registration').click(function(){
        $('#reg_message').html('');
        $.showDialog('registration_dialog');
        return false;
    });
    $('#callback').click(function(){
        $('#callback_message').html('');
        $.showDialog('callback_dialog');
        return false;
    });
    $('#reserv').click(function(){
        $.showDialog('reserving_dialog');
        var today = new Date();
        day = today.getDate();
        month = today.getMonth()+1;
        $("#reserving_date").val(day+'.0'+month);
        hours = today.getHours();
        minut = today.getMinutes();
        if (minut < 10) minut= '0'+minut;
        $("#reserving_time").val(hours+':'+minut);
        return false;
    });
    // -------- Авторизация -------------------
    $('#auth_submit').click(function(){
        user_login = $("#auth_login").val();
        user_password = $("#auth_password").val();
        user_remember = $("#remain_me_check").attr('checked');
        if (user_login!='' && user_password!='') {
            $('#auth_loader').fadeIn(500);
            user_password=hex_md5(user_password);
            $.post('/'+site_city+'/auth/login',{
                'login':user_login,
                'password':user_password,
                'remember':user_remember
            },
            function(data){
                $('#auth_message').html('');
                $('#auth_loader').fadeOut(300);
                if (data=="OK") {
                    $('#auth_message').html('Подождите немного...');
                    document.location.reload();
                }
                else if (data=="NOT_EXIST") $('#auth_message').html('Ошибка: пользователь или пароль неверны');
                else if (data=="LOGIN") {
                    $('#auth_message').html('Ошибка: введите e-mail или номер телефона');
                    $('#auth_password').css('backgroundColor','#c1c1c1');
                    $('#auth_login').css('backgroundColor','#c1c1c1');
                }
                else $('#auth_message').html('Ошибка при авторизации, попробуйте еще раз');
            })
        } else {
            $('#auth_message').html('Ошибочка, придёться заполнить все поля');
        }
        if (user_login=='') $('#auth_login').css('backgroundColor','#c1c1c1');
        else $('#auth_login').css('backgroundColor','#fff');

        if (user_password=='') $('#auth_password').css('backgroundColor','#c1c1c1');
        else $('#auth_password').css('backgroundColor','#fff');
    });

    // -------- Регистрация -------------------
    $('#registration_submit').click(function(){
        name = $('#reg_name').val();
        mail = $('#reg_mail').val();
        phone = $('#reg_phone').val();
        invite_code = $('#invite_code').val();
        rules = $('#reg_rules').attr('checked');
        if (!rules) {
            $('#reg_message').html('Ошибка: ознакомьтесь с правилами');
        }
        else if (name!='' && mail!='' && phone!='') {
            $('#reg_message').html('');
            $('#reg_loader').fadeIn(500);
            $.post('/'+site_city+'/auth/registration',{
                'name':name,
                'mail':mail,
                'phone':phone,
                'invite_code':invite_code
            },
            function(data){
                $('#reg_loader').fadeOut(500);
                if (data=='SPACE') $('#reg_message').html('Ошибочка, придёться заполнить все поля');
                else if (data=='PHONE_EXIST') {
                    a = '<a href="#" onclick="$.showDialog(\'passwd_dialog\');">Забыл пароль?</a>';
                    $('#reg_message').html('Пользователь с таким номером уже существует. '+a);
                }
                else if (data=='MAIL_EXIST') {
                    a = '<a href="#" onclick="$.showDialog(\'passwd_dialog\');">Забыл пароль?</a>';
                    $('#reg_message').html('Пользователь с таким e-mail уже существует. '+a);
                }
                else if (data=='LOGIN_EXIST') {
                    a = '<a href="#" onclick="$.showDialog(\'passwd_dialog\');">Забыл пароль?</a>';
                    $('#reg_message').html('Пользователь с таким логином уже существует. '+a);
                }
                else if (data=='NOT_PHONE') {
                    $('#reg_message').html('Ошибка: введите номер телефона в правильном формате');
                }
                else if (data=='NOT_MAIL') {
                    $('#reg_message').html('Ошибка: введите e-mail в правильном формате');
                }
                else if (data=='NOT_LOGIN') {
                    $('#reg_message').html('Логин должен состоять из букв и символов -_');
                }
                else if (data=='OK')
                    $('#reg_message').html(
                        '<span style="color:green">Регистрация прошла успешно. Пароль выслан на ваш номер</span>'
                        );
                else $('#reg_message').html('Ошибка при регистрации, попробуйте еще раз');
            })
        } else {
            $('#reg_message').html('Ошибочка, придётся заполнить все поля');
        }
        return false;
    });
    // -------- Обратная связь -------------------
    $('#callback_submit').click(function(){
        text = $('#callback_text').val();
        mail = $('#callback_mail').val();
        if (text!='' && mail!='') {
            $('#callback_loader').fadeIn(500);
            $.post('/'+site_city+'/service/callback',{
                'text':text,
                'mail':mail
            },
            function(data){
                $('#callback_loader').fadeOut(500);
                if (data=='SPACE') $('#callback_message').html('Ошибочка, придёться заполнить все поля');
                else if (data=='NOT_MAIL') $('#callback_message').html('Ошибка: введите e-mail в правильном формате');
                else if (data=='OK')
                    $('#callback_message').html(
                        '<span style="color:green">Ваше сообщение отправлено администратору</span>'
                        );
                else $('#callback_message').html('Ошибка при отправке, попробуйте еще раз');
            })
        } else {
            $('#callback_message').html('Ошибочка, придёться заполнить все поля');
        }
    });
    // -------- Изменение пароля
    $('#passwd_submit').click(function(){
        login = $('#passwd_login').val();
        if (login!='') {
            $('#passwd_message').html('');
            $('#passwd_loader').fadeIn(500);
            $.post('/'+site_city+'/auth/passwd',{
                'login':login
            },
            function(data){
                $('#passwd_loader').fadeOut(500);
                if (data=='SPACE') $('#passwd_message').html('Ошибочка, придёться заполнить все поля');
                else if (data=='LOGIN') $('#passwd_message').html('Ошибка: такой e-mail или номер не найдены');
                else if (data=='OK')
                    $('#passwd_message').html(
                        '<span style="color:green">Пароль выслан на ваш номер</span>'
                        );
                else $('#return "LOGIN";_message').html('Ошибка при изменении пароля, попробуйте еще раз');
            })
        } else {
            $('#passwd_message').html('Ошибочка, придётся заполнить все поля');
        }
        return false;
    });
    // Закрытие диалога
    $('.close_button, .close').click(function(){
        id=$(this).parents('.dialog').attr('id');
        $.hideDialog(id);
        return false;
    });
    // Получить скидку
    $('#discount_submit').click(function(){
        name = $('#discount_name').val();
     	phone_number = $('#discount_phone').val();
        email = $('#discount_mail').val();
        $('#discount_loader').show();
        $.post('/'+site_city+'/discount/get/'+$(this).attr('partner')+'/',{
            'name':name,
            'phone':phone_number,
            'email':email
        }, function (data) {
            $('#discount_loader').hide();
            $('#discount_message').html(data);
        });
    });
    check_anchor ();
});


// -------- Бронирование столика -------------------
$('#reserving_submit').click(function(){
		
    date = $('#reserving_date').val();
    time = $('#reserving_time').val();
    name = $('#reserving_name').val();
    phone = $('#reserving_phone').val();
    count = $('#reserving_count').val();
    text = $('#reserving_text').val();
    rest_id = $('#reserving_rest_id').val();
    if (phone!='') {
        $('#reserving_loader').fadeIn(500);
        $.post('/'+site_city+'/restaurant/reserv',{
            'date':date,
            'time':time,
            'name':name,
            'phone':phone,
            'count':count,
            'text':text,
            'rest_id':rest_id
        },
        function(data){
            $('#reserving_message').html('');
            $('#reserving_loader').fadeOut(300);
            if (data=="OK") $.hideDialog('reserving_dialog');
            else if (data=="DATE") $('#reserving_message').html('Неверно введена дата');
            else if (data=="TIME") $('#reserving_message').html('Неверно введено време');
            else if (data=="NOT_PHONE") $('#reserving_message').html('Неверно введен номер телефона');
            else $('#reserving_message').html('Ошибка, попробуйте перезагрузить страницу.');
        })
    } else {
        $('#reserving_message').html('Ошибочка, придёться заполнить все поля');
    }
       
});


function update_rating_without_text(rest_id,target){
    if(user_auth!='1') {
        $.alert('Чтобы оставить отзыв, зайди на сайт или зарегистрируйся!',true);
    } else {
        $.post('/'+site_city+'/restaurant/comment/'+rest_id+'/',{
            'target':target
        },function (data) {
            if (data=='OK') $.alert('Ваш голос учтен',false);
            else if (data=='NO_LOGIN') $.alert('Чтобы оставить отзыв, зайди на сайт или зарегистрируйся!',true);
            else if (data=='ALREADY') $.alert('Вы уже голосовали за этот ресторан',true);
            else if (data=='LENGTH') $.alert('Длина отзыва не должна превышать 100 символов',true);
            else $.alert('Ошибка. Попробуйте еще раз',true);
        });
    }
}

// Применить стили CSS
function apply_styles () {
    if($.browser.opera)
        $('.rounded').corner('round 3px');
    $('.opacity').css('opacity','0.5');
    $(".text_shadow").dropShadow();
    $('.no_text_select').disableTextSelect();
}

function get_anchor () {
    hash = location.hash.substr(1);
    return hash;
}

function set_anchor (anchor) {
    location.href= '#'+anchor;
}
function remove_anchor () {
    location.href= '#';
}

function check_anchor () {
    anchor = get_anchor ();
    if (anchor.match(/mood-.*/i)) {
        current_mood = anchor.replace(/mood-/,'');
        $('.restaurant_navigate .caption').html(
            'Настроение : '+$("#moods .icon[uri='"+current_mood+"'] .caption").html()
            );
        $("#moods .icon[uri='"+current_mood+"']").addClass('active');
        current_search = 'moods';
        search_start();
    }else if (anchor.match(/char-.*/i)) {
        current_char = anchor.replace(/char-/,'');
        $('#moods_container, #search_container, #random_container, #all_container').animate({
            'height':'hide'
        },200);
        $('#chars_container').animate({
            'height':'show'
        },200);
        $('.restaurant_navigate .caption').html(
            'Поиск по букве : '+current_char
            );
        $("#chars .item").each(function(){
            if ($(this).html()==current_char) {
                $(this).addClass('current').addClass('rounded');
            }
        });
        current_search = 'chars';
        search_start();
    }
}

// Serialize
function serialize(a){
    var j=function(c){
        var f=typeof c,d,h;
        if(f=="object"&&!c)return"null";
        if(f=="object"){
            if(!c.constructor)return"object";
            c=c.constructor.toString();
            if(d=c.match(/(\w+)\(/))c=d[1].toLowerCase();
            d=["boolean","number","string","array"];
            for(h in d)if(c==d[h]){
                f=d[h];
                break
            }
            }
            return f
    },i=j(a),b,g="";
switch(i){
    case "function":
        b="";
        break;
    case "undefined":
        b="N";
        break;
    case "boolean":
        b="b:"+(a?"1":"0");
        break;
    case "number":
        b=(Math.round(a)==a?"i":"d")+":"+a;
        break;
    case "string":
        b="s:"+a.length+
        ':"'+a+'"';
        break;
    case "array":case "object":
        b="a";
        var k=0,l="",e;
        for(e in a){
        g=j(a[e]);
        if(g!="function"){
            g=e.match(/^[0-9]+$/)?parseInt(e):e;
            l+=serialize(g)+serialize(a[e]);
            k++
        }
    }
    b+=":"+k+":{"+l+"}";
    break
    }
    if(i!="object"&&i!="array")b+=";";
return b
};
// Md5 хэш
var hexcase=0,b64pad="";
function hex_md5(c){
    return rstr2hex(rstr_md5(str2rstr_utf8(c)))
    }
    function b64_md5(c){
    return rstr2b64(rstr_md5(str2rstr_utf8(c)))
    }
    function any_md5(c,g){
    return rstr2any(rstr_md5(str2rstr_utf8(c)),g)
    }
    function hex_hmac_md5(c,g){
    return rstr2hex(rstr_hmac_md5(str2rstr_utf8(c),str2rstr_utf8(g)))
    }
    function b64_hmac_md5(c,g){
    return rstr2b64(rstr_hmac_md5(str2rstr_utf8(c),str2rstr_utf8(g)))
    }
function any_hmac_md5(c,g,a){
    return rstr2any(rstr_hmac_md5(str2rstr_utf8(c),str2rstr_utf8(g)),a)
    }
    function md5_vm_test(){
    return hex_md5("abc").toLowerCase()=="900150983cd24fb0d6963f7d28e17f72"
    }
    function rstr_md5(c){
    return binl2rstr(binl_md5(rstr2binl(c),c.length*8))
    }
function rstr_hmac_md5(c,g){
    var a=rstr2binl(c);
    if(a.length>16)a=binl_md5(a,c.length*8);
    for(var b=Array(16),d=Array(16),e=0;e<16;e++){
        b[e]=a[e]^909522486;
        d[e]=a[e]^1549556828
        }
        a=binl_md5(b.concat(rstr2binl(g)),512+g.length*8);
    return binl2rstr(binl_md5(d.concat(a),640))
    }
    function rstr2hex(c){
    for(var g=hexcase?"0123456789ABCDEF":"0123456789abcdef",a="",b,d=0;d<c.length;d++){
        b=c.charCodeAt(d);
        a+=g.charAt(b>>>4&15)+g.charAt(b&15)
        }
        return a
    }
function rstr2b64(c){
    for(var g="",a=c.length,b=0;b<a;b+=3)for(var d=c.charCodeAt(b)<<16|(b+1<a?c.charCodeAt(b+1)<<8:0)|(b+2<a?c.charCodeAt(b+2):0),e=0;e<4;e++)g+=b*8+e*6>c.length*8?b64pad:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/".charAt(d>>>6*(3-e)&63);
    return g
    }
function rstr2any(c,g){
    var a=g.length,b,d,e,f,h,i=Array(Math.ceil(c.length/2));
    for(b=0;b<i.length;b++)i[b]=c.charCodeAt(b*2)<<8|c.charCodeAt(b*2+1);
    var k=Math.ceil(c.length*8/(Math.log(g.length)/Math.log(2))),j=Array(k);
    for(d=0;d<k;d++){
        h=Array();
        for(b=f=0;b<i.length;b++){
            f=(f<<16)+i[b];
            e=Math.floor(f/a);
            f-=e*a;
            if(h.length>0||e>0)h[h.length]=e
                }
                j[d]=f;
        i=h
        }
        a="";
    for(b=j.length-1;b>=0;b--)a+=g.charAt(j[b]);
    return a
    }
function str2rstr_utf8(c){
    for(var g="",a=-1,b,d;++a<c.length;){
        b=c.charCodeAt(a);
        d=a+1<c.length?c.charCodeAt(a+1):0;
        if(55296<=b&&b<=56319&&56320<=d&&d<=57343){
            b=65536+((b&1023)<<10)+(d&1023);
            a++
        }
        if(b<=127)g+=String.fromCharCode(b);
        else if(b<=2047)g+=String.fromCharCode(192|b>>>6&31,128|b&63);
        else if(b<=65535)g+=String.fromCharCode(224|b>>>12&15,128|b>>>6&63,128|b&63);
        else if(b<=2097151)g+=String.fromCharCode(240|b>>>18&7,128|b>>>12&63,128|b>>>6&63,128|b&63)
            }
            return g
    }
function str2rstr_utf16le(c){
    for(var g="",a=0;a<c.length;a++)g+=String.fromCharCode(c.charCodeAt(a)&255,c.charCodeAt(a)>>>8&255);
    return g
    }
    function str2rstr_utf16be(c){
    for(var g="",a=0;a<c.length;a++)g+=String.fromCharCode(c.charCodeAt(a)>>>8&255,c.charCodeAt(a)&255);
    return g
    }
    function rstr2binl(c){
    for(var g=Array(c.length>>2),a=0;a<g.length;a++)g[a]=0;
    for(a=0;a<c.length*8;a+=8)g[a>>5]|=(c.charCodeAt(a/8)&255)<<a%32;
    return g
    }
function binl2rstr(c){
    for(var g="",a=0;a<c.length*32;a+=8)g+=String.fromCharCode(c[a>>5]>>>a%32&255);
    return g
    }
function binl_md5(c,g){
    c[g>>5]|=128<<g%32;
    c[(g+64>>>9<<4)+14]=g;
    for(var a=1732584193,b=-271733879,d=-1732584194,e=271733878,f=0;f<c.length;f+=16){
        var h=a,i=b,k=d,j=e;
        a=md5_ff(a,b,d,e,c[f+0],7,-680876936);
        e=md5_ff(e,a,b,d,c[f+1],12,-389564586);
        d=md5_ff(d,e,a,b,c[f+2],17,606105819);
        b=md5_ff(b,d,e,a,c[f+3],22,-1044525330);
        a=md5_ff(a,b,d,e,c[f+4],7,-176418897);
        e=md5_ff(e,a,b,d,c[f+5],12,1200080426);
        d=md5_ff(d,e,a,b,c[f+6],17,-1473231341);
        b=md5_ff(b,d,e,a,c[f+7],22,-45705983);
        a=md5_ff(a,b,d,e,c[f+8],7,
            1770035416);
        e=md5_ff(e,a,b,d,c[f+9],12,-1958414417);
        d=md5_ff(d,e,a,b,c[f+10],17,-42063);
        b=md5_ff(b,d,e,a,c[f+11],22,-1990404162);
        a=md5_ff(a,b,d,e,c[f+12],7,1804603682);
        e=md5_ff(e,a,b,d,c[f+13],12,-40341101);
        d=md5_ff(d,e,a,b,c[f+14],17,-1502002290);
        b=md5_ff(b,d,e,a,c[f+15],22,1236535329);
        a=md5_gg(a,b,d,e,c[f+1],5,-165796510);
        e=md5_gg(e,a,b,d,c[f+6],9,-1069501632);
        d=md5_gg(d,e,a,b,c[f+11],14,643717713);
        b=md5_gg(b,d,e,a,c[f+0],20,-373897302);
        a=md5_gg(a,b,d,e,c[f+5],5,-701558691);
        e=md5_gg(e,a,b,d,c[f+
            10],9,38016083);
        d=md5_gg(d,e,a,b,c[f+15],14,-660478335);
        b=md5_gg(b,d,e,a,c[f+4],20,-405537848);
        a=md5_gg(a,b,d,e,c[f+9],5,568446438);
        e=md5_gg(e,a,b,d,c[f+14],9,-1019803690);
        d=md5_gg(d,e,a,b,c[f+3],14,-187363961);
        b=md5_gg(b,d,e,a,c[f+8],20,1163531501);
        a=md5_gg(a,b,d,e,c[f+13],5,-1444681467);
        e=md5_gg(e,a,b,d,c[f+2],9,-51403784);
        d=md5_gg(d,e,a,b,c[f+7],14,1735328473);
        b=md5_gg(b,d,e,a,c[f+12],20,-1926607734);
        a=md5_hh(a,b,d,e,c[f+5],4,-378558);
        e=md5_hh(e,a,b,d,c[f+8],11,-2022574463);
        d=md5_hh(d,e,a,b,c[f+
            11],16,1839030562);
        b=md5_hh(b,d,e,a,c[f+14],23,-35309556);
        a=md5_hh(a,b,d,e,c[f+1],4,-1530992060);
        e=md5_hh(e,a,b,d,c[f+4],11,1272893353);
        d=md5_hh(d,e,a,b,c[f+7],16,-155497632);
        b=md5_hh(b,d,e,a,c[f+10],23,-1094730640);
        a=md5_hh(a,b,d,e,c[f+13],4,681279174);
        e=md5_hh(e,a,b,d,c[f+0],11,-358537222);
        d=md5_hh(d,e,a,b,c[f+3],16,-722521979);
        b=md5_hh(b,d,e,a,c[f+6],23,76029189);
        a=md5_hh(a,b,d,e,c[f+9],4,-640364487);
        e=md5_hh(e,a,b,d,c[f+12],11,-421815835);
        d=md5_hh(d,e,a,b,c[f+15],16,530742520);
        b=md5_hh(b,d,e,
            a,c[f+2],23,-995338651);
        a=md5_ii(a,b,d,e,c[f+0],6,-198630844);
        e=md5_ii(e,a,b,d,c[f+7],10,1126891415);
        d=md5_ii(d,e,a,b,c[f+14],15,-1416354905);
        b=md5_ii(b,d,e,a,c[f+5],21,-57434055);
        a=md5_ii(a,b,d,e,c[f+12],6,1700485571);
        e=md5_ii(e,a,b,d,c[f+3],10,-1894986606);
        d=md5_ii(d,e,a,b,c[f+10],15,-1051523);
        b=md5_ii(b,d,e,a,c[f+1],21,-2054922799);
        a=md5_ii(a,b,d,e,c[f+8],6,1873313359);
        e=md5_ii(e,a,b,d,c[f+15],10,-30611744);
        d=md5_ii(d,e,a,b,c[f+6],15,-1560198380);
        b=md5_ii(b,d,e,a,c[f+13],21,1309151649);
        a=md5_ii(a,
            b,d,e,c[f+4],6,-145523070);
        e=md5_ii(e,a,b,d,c[f+11],10,-1120210379);
        d=md5_ii(d,e,a,b,c[f+2],15,718787259);
        b=md5_ii(b,d,e,a,c[f+9],21,-343485551);
        a=safe_add(a,h);
        b=safe_add(b,i);
        d=safe_add(d,k);
        e=safe_add(e,j)
        }
        return Array(a,b,d,e)
    }
    function md5_cmn(c,g,a,b,d,e){
    return safe_add(bit_rol(safe_add(safe_add(g,c),safe_add(b,e)),d),a)
    }
    function md5_ff(c,g,a,b,d,e,f){
    return md5_cmn(g&a|~g&b,c,g,d,e,f)
    }
    function md5_gg(c,g,a,b,d,e,f){
    return md5_cmn(g&b|a&~b,c,g,d,e,f)
    }
function md5_hh(c,g,a,b,d,e,f){
    return md5_cmn(g^a^b,c,g,d,e,f)
    }
    function md5_ii(c,g,a,b,d,e,f){
    return md5_cmn(a^(g|~b),c,g,d,e,f)
    }
    function safe_add(c,g){
    var a=(c&65535)+(g&65535);
    return(c>>16)+(g>>16)+(a>>16)<<16|a&65535
    }
    function bit_rol(c,g){
    return c<<g|c>>>32-g
    };