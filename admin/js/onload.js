$(document).ready(
    function() {
        $("#rest_list").css({
            "width" : parseInt($("#content .right").width())-20
        });

        $("#rest_change").click(function(){
            $("#rest_list").toggle();
        });

        $("input").replaceInput();
        $("textarea").replaceTextarea();
        

        // UI
        $(".ui_button").button();
        $("#menu").tabs();
        $(".ui-button-text").css('padding',6);
        $(".ui-tabs-panel").css('padding','6px 5px');
        $(".datepicker").parent().find('input').each(function(){
            date = $(this).val();
            $(this).datepicker().datepicker('option', {dateFormat: 'yy-mm-dd'});
            if (date!='') {
                $(this).datepicker('option', {
                    defaultDate: date
                }).datepicker( "setDate", date);
            }
        });

        loc = location.href.match(/page=(.*)/);
        if (typeof(loc[1])!='undefined') {
            $("#menu").tabs("select", $('li[rel="'+loc[1]+'"]').parents('.submenu').attr('id') );
        }
    });

function toggleItem(item) {
    var item_id = item;
    $.post('/admin/admin.php?page=restaurants&action=toggleItem',{
        'id':item_id
    },function(data){
        //  alert(data);
        });
}