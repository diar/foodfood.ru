//----------------- Системные функции ----------
$loader = '<div class="loader"><img src="/public/images/loader.gif" alt="Загрузка..." /></div>';
$loader_gray = '<div class="loader"><img src="/public/images/loader_gray.gif" alt="Загрузка..." /></div>';
jQuery.noConflict()(function(){
    // Показать диалог
    $showDialog = function (id) {
        $body_fill = jQuery('#body_fill');
        // Показываем затемнение
        if (jQuery('#body_fill').length==0) {
            $body_fill = jQuery('<div id="body_fill"></div>');
            jQuery('body').append($body_fill);
        }
        $body_fill.css('opacity',0).show().animate({
            'opacity':0.5
        },300);
        // Показываем диалог
        jQuery('#'+id).css('top',100);
        jQuery('.dialog:not(#'+id+')').fadeOut(300,function(){
            jQuery('#'+id).fadeIn(300);
        });
    };

    // Показать диалог
    $hideDialog = function (id) {
        jQuery('#body_fill').animate({
            'opacity':0
        },300).hide();
        jQuery('#'+id).fadeOut(300);
    };

    jQuery('dialog_box input[type="text"],dialog_box input[type="password"]').keyboard('enter',function(){
        jQuery(this).parents('.ajax_form').find('input[type="button"]').click();
        return false;
    });
    jQuery('.profile .reg').click(function(){
        jQuery('#reg_message').html('');
        $showDialog('registration_dialog');
        return false;
    });
    jQuery('.profile .auth').click(function(){
        jQuery('#auth_message').html('');
        $showDialog('auth_dialog');
        return false;
    });
    // -------- Авторизация -------------------
    jQuery('#auth_submit').click(function(){
        login = jQuery('#auth_login').val();
        password = jQuery('#auth_password').val();
        remember = jQuery('#remain_me_check').attr('checked');
        if (login!='' && password!='') {
            jQuery('#auth_loader').fadeIn(500);
            password=hex_md5(password);
            jQuery.post('/kazan/auth/login',{
                'login':login,
                'password':password,
                'remember':remember
            },
            function(data){
                jQuery('#auth_message').html('');
                jQuery('#auth_loader').fadeOut(300);
                if (data=="OK") {
                    jQuery('#auth_message').html('Подождите немного...');
                    document.location.reload();
                }
                else if (data=="NOT_EXIST") jQuery('#auth_message').html('Ошибка: пользователь или пароль неверны');
                else if (data=="LOGIN") {
                    jQuery('#auth_message').html('Ошибка: введите e-mail или номер телефона');
                    jQuery('#auth_password').css('backgroundColor','#c1c1c1');
                    jQuery('#auth_login').css('backgroundColor','#c1c1c1');
                }
                else jQuery('#auth_message').html('Ошибка при авторизации, попробуйте еще раз');
            })
        } else {
            jQuery('#auth_message').html('Ошибочка, придётся заполнить все поля');
        }
        if (login=='') jQuery('#auth_login').css('backgroundColor','#c1c1c1');
        else jQuery('#auth_login').css('backgroundColor','#fff');

        if (password=='') jQuery('#auth_password').css('backgroundColor','#c1c1c1');
        else jQuery('#auth_password').css('backgroundColor','#fff');
    });

    // -------- Регистрация -------------------
    jQuery('#registration_submit').click(function(){
        name = jQuery('#reg_name').val();
        mail = jQuery('#reg_mail').val();
        phone = jQuery('#reg_phone').val();
        rules = jQuery('#reg_rules').attr('checked');
        if (!rules) {
            jQuery('#reg_message').html('Ошибка: ознакомьтесь с правилами');
        }
        else if (name!='' && mail!='' && phone!='') {
            jQuery('#reg_message').html('');
            jQuery('#reg_loader').fadeIn(500);
            jQuery.post('/kazan/auth/registration',{
                'name':name,
                'mail':mail,
                'phone':phone
            },
            function(data){
                jQuery('#reg_loader').fadeOut(500);
                if (data=='SPACE') jQuery('#reg_message').html('Ошибочка, придёться заполнить все поля');
                else if (data=='PHONE_EXIST') {
                    a = '<a href="#" class="passwd">Забыл пароль?</a>';
                    jQuery('#reg_message').html('Пользователь с таким номером уже существует. '+a);
                }
                else if (data=='MAIL_EXIST') {
                    a = '<a href="#" class="passwd">Забыл пароль?</a>';
                    jQuery('#reg_message').html('Пользователь с таким e-mail уже существует. '+a);
                }
                else if (data=='LOGIN_EXIST') {
                    a = '<a href="#" onclick="$.showDialog(\'passwd_dialog\');">Забыл пароль?</a>';
                    jQuery('#reg_message').html('Пользователь с таким логином уже существует. '+a);
                }
                else if (data=='NOT_PHONE') {
                    jQuery('#reg_message').html('Ошибка: введите номер телефона в правильном формате');
                }
                else if (data=='NOT_MAIL') {
                    jQuery('#reg_message').html('Ошибка: введите e-mail в правильном формате');
                }
                else if (data=='NOT_LOGIN') {
                    $('#reg_message').html('Ошибка: логин должен состоять из букв и символов "-", "_"');
                }
                else if (data=='OK')
                    jQuery('#reg_message').html(
                        '<span style="color:green">Регистрация прошла успешно. Пароль выслан на ваш номер</span>'
                        );
                else jQuery('#reg_message').html('Ошибка при регистрации, попробуйте еще раз');
            })
        } else {
            jQuery('#reg_message').html('Ошибочка, придётся заполнить все поля');
        }
        return false;
    });
    // -------- Изменение пароля
    jQuery('#passwd_submit').click(function(){
        login = jQuery('#passwd_login').val();
        if (login!='') {
            jQuery('#passwd_message').html('');
            jQuery('#passwd_loader').fadeIn(500);
            jQuery.post('/kazan/auth/passwd',{
                'login':login
            },
            function(data){
                jQuery('#passwd_loader').fadeOut(500);
                if (data=='SPACE') jQuery('#passwd_message').html('Ошибочка, придёться заполнить все поля');
                else if (data=='LOGIN') jQuery('#passwd_message').html('Ошибка: такой e-mail или номер не найдены');
                else if (data=='OK')
                    jQuery('#passwd_message').html(
                        '<span style="color:green">Пароль выслан на ваш номер</span>'
                        );
                else jQuery('#return "LOGIN";_message').html('Ошибка при изменении пароля, попробуйте еще раз');
            })
        } else {
            jQuery('#passwd_message').html('Ошибочка, придёться заполнить все поля');
        }
        return false;
    });
    // Закрытие диалога
    jQuery('.close_button, .close').click(function(){
        id=jQuery(this).parents('.dialog').attr('id');
        $hideDialog(id);
        return false;
    });
    // Закрытие диалога
    jQuery('.passwd').click(function(){
        $showDialog('passwd_dialog');
    });
});