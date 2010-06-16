$.initDrag = function (gallery,trash,tag,page){
    var $gallery = $('#'+gallery), $trash = $('#'+trash);

    $('.'+tag).draggable({
        cancel: 'a.ui-icon',
        revert: 'invalid',
        helper: 'clone',
        cursor: 'move'
    });

    $trash.droppable({
        accept: '.'+tag,
        activeClass: 'on-drop-css',
        drop: function(ev, ui) {
            deleteImage(ui.draggable);
        }
    });

    $gallery.droppable({
        accept: '.'+tag,
        activeClass: 'on-drop-css',
        drop: function(ev, ui) {
            recycleImage(ui.draggable);
        }
    });

    function deleteImage($item) {
        $item.fadeOut(function() {
            $item.find('a.ui-icon-trash').remove();
            $item.appendTo($trash).fadeIn();
        });
        $.post('/admin/admin.php?page='+page+'&action=add',{'item':$item.attr('id')});
    }

    function recycleImage($item) {
        $item.fadeOut(function() {
            $item.find('a.ui-icon-refresh').remove();
            $item.appendTo($gallery).fadeIn();
        });
        $.post('/admin/admin.php?page='+page+'&action=delete',{'item':$item.attr('id')});
    }

    $('#'+gallery+' .'+tag).dblclick(function(){
        deleteImage($(this));
    });
    
    $('#'+trash+' .'+tag).dblclick(function(){
        recycleImage($(this));
    });
}