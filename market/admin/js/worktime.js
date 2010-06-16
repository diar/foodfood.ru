$(document).ready(function () {
    $('#add_worktime').click(function(){
        $row = $('<tr class="row_worktime">'+$('#copipaster').html()+'</tr>');
        $('#worktime').append($row);
        $row.find('.remove_worktime').click(function(){
            $(this).parents('.row_worktime').remove();
        });
    });
    $('#save_worktime').click(function(){
        rows = Array ();
        i=0;
        $('#worktime .row_worktime').each(function(){
            i++;
            row = Array ();
            row['start_week'] = $(this).find('.week .start').val();
            row['end_week'] = $(this).find('.week .end').val();
            row['start_hour'] = $(this).find('.time .start.hour').val();
            row['start_minute'] = $(this).find('.time .start.minute').val();
            row['end_hour'] = $(this).find('.time .end.hour').val();
            row['end_minute'] = $(this).find('.time .end.minute').val();
            rows[i]=row;
        });
        $.post('/admin/admin.php?page=worktime&action=save',{
            'rows':serialize(rows)
            },function(data){
                alert('Данные сохранены');
        });
    });
    $('#worktime .row_worktime').each(function(){
        selected_start_week = $(this).find('.week .start').attr('selected');
        $(this).find('.week .start option[value='+selected_start_week+']').attr('selected','true');
        selected_start_hour = $(this).find('.time .start.hour').attr('selected');
        $(this).find('.time .start.hour option[value='+selected_start_hour+']').attr('selected','true');
        selected_start_minute = $(this).find('.time .start.minute').attr('selected');
        $(this).find('.time .start.minute option[value='+selected_start_minute+']').attr('selected','true');
        selected_end_week = $(this).find('.week .end').attr('selected');
        $(this).find('.week .end option[value='+selected_end_week+']').attr('selected','true');
        selected_end_hour = $(this).find('.time .end.hour').attr('selected');
        $(this).find('.time .end.hour option[value='+selected_end_hour+']').attr('selected','true');
        selected_end_minute = $(this).find('.time .end.minute').attr('selected');
        $(this).find('.time .end.minute option[value='+selected_end_minute+']').attr('selected','true');

        $(this).find('.remove_worktime').click(function(){
            $(this).parents('.row_worktime').remove();
        });
    });
});

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