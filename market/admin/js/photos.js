$(document).ready(function () {
    del_disable ();
    var ident;
    $('#image').css('opacity',0).change(function(){
        str=$(this).val();
        if (str!='') {
            //Проверяем, разрешена ли загрузка такого расширения
            ind=str.split('.');
            ext=ind[ind.length-1];
            if (in_array(ext,['png','jpg','jpeg','gif'])) {
                $('#imgform').submit();
                ident = Math.floor(Math.random()*1000);
                // Показываем контейнер изображения
                $('<div class="photo_container"><div class="photo_item" rel="'+ident+'"><img class="photo" /></div></div>')
                .append('<img src="/public/images/loader.gif" class="photo_loader" id="load_'+ident+'" />')
                .appendTo('#photos');
            }
            else alert('Недопустимый формат файла');
            $('#imgform').fadeOut(700);
            $(this).val('');
        }
    });
    $('#photo_delete').click(function(){
        photo_id = Array ();
        photo_src = Array ();
        $('.photo_item.active').each(function(){
            photo_id [photo_id.length] = $(this).attr('id');
            photo_src [photo_src.length] = $(this).find('img').attr('src');
            el_id = $(this).attr('id');
            $('.photo_container:has(#'+el_id+')').remove();
            $(this).find('.photo').hide();
            $(this).find('.photo_loader').show();
        });
        $.post('/admin/admin.php?page=restPhotos&action=delete',{
            'photo_id':photo_id,
            'photo_src':photo_src
        },function(data){
            if (data=='OK') {
        }
        });
        del_disable ();
    });
    $('#frame').load(function(){
        // Обрабатываем ответ с сервера
        response = $.parseJSON(
            $('#frame').contents().find('#response').html()
            );
        photo_id = 'photo'+response.id;

        // Показываем изображение
        $('.photo_item[rel='+ident+']').attr('id',photo_id)
            .find('.photo').attr('src',response.filename);
        $('#'+photo_id+' .photo').load(function(){
            $('#load_'+ident).hide();
        });
        // Обработка нажатия на изображение
        $('#'+photo_id).click(function(e){
            if (!e.ctrlKey) {
                $('.photo_item').removeClass('active');
                $(this).addClass('active');
            } else {
                $(this).toggleClass('active');
            }
            del_disable ();
        });
        $('#imgform').fadeIn(700);
    });
    // Обработка нажатия на изображение
    $('.photo_item').click(function(e){
        if (!e.ctrlKey) {
            $('.photo_item').removeClass('active');
            $(this).addClass('active');
        } else {
            $(this).toggleClass('active');
        }
        del_disable ();
    });
    function del_disable (){
        var i=0;
        $('.photo_item.active').each(function(){
            i++;
        });
        if (i>0) $('#photo_delete').removeAttr('disabled');
        else $('#photo_delete').attr('disabled','disabled');
    }
});

