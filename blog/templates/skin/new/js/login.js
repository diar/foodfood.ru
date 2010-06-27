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
    $body_fill.css('opacity',0).show().animate({'opacity':0.5},300);
    // Показываем диалог
    $('#'+id).css('top',100);
    $('.dialog:not(#'+id+')').fadeOut(300,function(){
        $('#'+id).fadeIn(300);
    });
};

// Показать диалог
$.hideDialog = function (id) {
    $('#body_fill').animate({'opacity':0},300).hide();
    $('#'+id).fadeOut(300);
};

// Выполнение после загрузки на всех страницах
$(document).ready(function () {
    $('dialog_box input[type="text"],dialog_box input[type="password"]').keyboard('enter',function(){
        $(this).parents('.ajax_form').find('input[type="button"]').click();
        return false;
    });
    $('.profile .reg').click(function(){
        $('#reg_message').html('');
        $.showDialog('registration_dialog');
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
            $.post('/kazan/auth/login',{
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
        rules = $('#reg_rules').attr('checked');
        if (!rules) {
            $('#reg_message').html('Ошибка: ознакомьтесь с правилами');
        }
        else if (name!='' && mail!='' && phone!='') {
            $('#reg_message').html('');
            $('#reg_loader').fadeIn(500);
            $.post('/kazan/auth/registration',{
                'name':name,
                'mail':mail,
                'phone':phone
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
                else if (data=='NOT_PHONE') $('#reg_message').html('Ошибка: введите номер телефона в правильном формате');
                else if (data=='NOT_MAIL') $('#reg_message').html('Ошибка: введите e-mail в правильном формате');
                else if (data=='OK')
                    $('#reg_message').html(
                        '<span style="color:green">Регистрация прошла успешно. Пароль выслан на ваш номер</span>'
                        );
                else $('#reg_message').html('Ошибка при регистрации, попробуйте еще раз');
            })
        } else {
            $('#reg_message').html('Ошибочка, придёться заполнить все поля');
        }
        return false;
    });
    // -------- Изменение пароля
    $('#passwd_submit').click(function(){
        login = $('#passwd_login').val();
        if (login!='') {
            $('#passwd_message').html('');
            $('#passwd_loader').fadeIn(500);
            $.post('/kazan/auth/passwd',{
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
            $('#passwd_message').html('Ошибочка, придёться заполнить все поля');
        }
        return false;
    });
    // Закрытие диалога
    $('.close_button, .close').click(function(){
        id=$(this).parents('.dialog').attr('id');
        $.hideDialog(id);
        return false;
    });
});

function showLoginForm() {	
    $('#auth_message').html('');
        $.showDialog('auth_dialog');
        return false;
}