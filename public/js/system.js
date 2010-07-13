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
    // -------- Авторизация -------------------
    $('#auth_submit').click(function(){
        login = $('#auth_login').val();
        password = $('#auth_password').val();
        remember = $('#remain_me_check').attr('checked');
        if (login!='' && password!='') {
            $('#auth_loader').fadeIn(500);
            password=hex_md5(password);
            $.post('/'+site_city+'/auth/login',{
                'login':login,
                'password':password,
                'remember':remember
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
        if (login=='') $('#auth_login').css('backgroundColor','#c1c1c1');
        else $('#auth_login').css('backgroundColor','#fff');

        if (password=='') $('#auth_password').css('backgroundColor','#c1c1c1');
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
        phone = $('#discount_phone').val();
        email = $('#discount_mail').val();
        $('#discount_loader').show();
        $.post('/'+site_city+'/discount/get/'+$(this).attr('partner')+'/',{
            'name':name,
            'phone':phone,
            'email':email
        }, function (data) {
            $('#discount_loader').hide();
            $('#discount_message').html(data);
        });
    });
    check_anchor ();
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

function serialize( mixed_value ) {
    var _getType = function( inp ) {
        var type = typeof inp, match;
        var key;
        if (type == 'object' && !inp) {
            return 'null';
        }
        if (type == "object") {
            if (!inp.constructor) {
                return 'object';
            }
            var cons = inp.constructor.toString();
            if (match = cons.match(/(\w+)\(/)) {
                cons = match[1].toLowerCase();
            }
            var types = ["boolean", "number", "string", "array"];
            for (key in types) {
                if (cons == types[key]) {
                    type = types[key];
                    break;
                }
            }
        }
        return type;
    };
    var type = _getType(mixed_value);
    var val, ktype = '';
    switch (type) {
        case "function":
            val = "";
            break;
        case "undefined":
            val = "N";
            break;
        case "boolean":
            val = "b:" + (mixed_value ? "1" : "0");
            break;
        case "number":
            val = (Math.round(mixed_value) == mixed_value ? "i" : "d") + ":" + mixed_value;
            break;
        case "string":
            val = "s:" + mixed_value.length + ":\"" + mixed_value + "\"";
            break;
        case "array":
        case "object":
            val = "a";
            var count = 0;
            var vals = "";
            var okey;
            var key;
            for (key in mixed_value) {
                ktype = _getType(mixed_value[key]);
                if (ktype == "function") {
                    continue;
                }
                okey = (key.match(/^[0-9]+$/) ? parseInt(key) : key);
                vals += serialize(okey) +
                serialize(mixed_value[key]);
                count++;
            }
            val += ":" + count + ":{" + vals + "}";
            break;
    }
    if (type != "object" && type != "array") val += ";";
    return val;
}

// Добавить в Избранное
function bookmark(a) {
    title=document.title;
    url=document.location;
    if ($.browser.msie) {
        window.external.AddFavorite(url, title);
    }
    if ($.browser.mozilla) {
        window.sidebar.addPanel(title, url, "");
    }
    if ($.browser.opera) {
        a.rel="sidebar";
        a.title=title;
        a.url=url;
        return true;
    }
    return false;
}