var map;
var geocoder;
var latlng;
var address;
var marker;

$(document).ready(
    function() {
        $('#change_google_map').click(function(){
            $.showMap();
            return false;
        });
    });
$.showMap = function (id) {
    if(!$.browser.msie) {
        scrolling = $(document).scrollTop()+200;
    } else {
        scrolling = document.documentElement.scrollTop + 150;
    }
    $map = $('#google_map_dialog');
    if ($map.length==0) {
        $map = $(
            '<div id="google_map_dialog"><input id="google_address" style="width:340px;" />'+
            '<input type="button" id="google_search" style="width:100px;margin:0 10px;" value="поиск" />'+
            '<input type="button" id="google_save" style="width:100px;" value="сохранить" />'+
            '<div id="google_map" style="width:600px;height:460px"></div></div>'
            );
        $('body').append($map);
        $map.css('top',scrolling);
        $map.fadeIn(500,function(){
            map_init();
        });
    } else {
        $map.css('top',scrolling);
        $map.fadeIn(500);
    }
    $('#google_save').click(function() {
        position = marker.getPosition();
        $('#google_location_html_position').html(position.toString());
        $('.google_location').val(position.toString());
        $map.fadeOut();
    });
    $('#google_search').click(function() {
        address = $("#google_address").val();
        if (geocoder) {
            geocoder.geocode( {
                'address': address
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    if (typeof(marker)!='undefined') {
                        marker.setPosition(results[0].geometry.location)
                    } else {
                        marker = new google.maps.Marker({
                            map: map,
                            draggable:true,
                            position: results[0].geometry.location
                        });
                    }
                } else {
                    alert("Не удалось найти адрес: " + status);
                }
            });
        }
    });
};

function map_init() {
    locat = $('.google_location').val();
    locat_arr = locat.replace(')','').replace('(','').split(',');
    latlng = new google.maps.LatLng(locat_arr[0],locat_arr[1]);
    var myOptions = {
        zoom: 16,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("google_map"), myOptions);
    geocoder = new google.maps.Geocoder();
    marker = new google.maps.Marker({
        map: map,
        draggable:true,
        position: latlng
    });
    cur_address = 'Казань, '+$('#rest_addressfield').val();
    $("#google_address").val(cur_address);
}