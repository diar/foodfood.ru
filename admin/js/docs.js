$(document).ready(function () {
    del_disable ();
    $('#image').css('opacity',0).change(function(){
        $('#image').css('opacity',0).change(function(){
            str=$(this).val();
            if (str!='') {
                ind=str.split('.');
                ext=ind[ind.length-1];
                if (in_array(ext,['doc','docx','xls','xlsx','jpg','pdf']))
                    $('#imgform').submit();
                else alert('Недопустимый формат файла');
            }
        });
    });
    $('#doc_upload').click(function(){
        $('#image').click();
    });
    $('#photo_delete').click(function(){
        doc_id = Array ();
        $('.doc.active').each(function(){
            doc_id [doc_id.length] = $(this).attr('id');
            $(this).remove();
        });
        $.post('/admin/admin.php?page=restDocs&action=delete',{
            'doc_id':doc_id
        },function(data){
            
            });
        del_disable ();
    });
    $('#frame').load(function(){
        // Обрабатываем ответ с сервера
        response = $.parseJSON(
            $('#frame').contents().find('#response').html()
            );
        doc_id = 'doc'+response.id;

        // Создаем изображение и добавляем его в фотогалерею
        $('<div class="doc" id="'+doc_id+'">'+response.title+'</div>').appendTo('#docs');
        // Обработка нажатия на изображение
        $('#'+doc_id).click(function(e){
            if (!e.ctrlKey) {
                $('.doc').removeClass('active');
                $(this).addClass('active');
            } else {
                $(this).toggleClass('active');
            }
            del_disable ();
        });
    });
    // Обработка нажатия на изображение
    $('.doc').click(function(e){
        if (!e.ctrlKey) {
            $('.doc').removeClass('active');
            $(this).addClass('active');
        } else {
            $(this).toggleClass('active');
        }
        del_disable ();
    });
    function del_disable (){
        var i=0;
        $('.doc.active').each(function(){
            i++;
        });
        if (i>0) $('#doc_delete').removeAttr('disabled');
        else $('#doc_delete').attr('disabled','disabled');
    }
});

