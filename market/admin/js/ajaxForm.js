
$(document).ready(
    function() {
	
        $("#apply").click(function(){
			
            var options = {
                //url: getModuleLink()+"&action=apply",
                target: "#divToUpdate",
                type: "POST",
                beforeSubmit: function () {
                    $("form input,form textarea").attr('disabled','disabled');
                },
                success: function() {
                    //				alert("Be happy:)");
                    $("form input,form textarea").removeAttr('disabled');
                }
            }
			
            var formID = "#" + $("form:has(#apply)").attr('id');
			
            $(formID).ajaxSubmit(options);
			
            return false;
			
        });

    }
    );


	