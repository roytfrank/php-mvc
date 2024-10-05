(function(){
	"use strict";
	REJOY.admin.deletesubcategory = function(){
		$(".deletesubCategory").on("click", function(e){
             var token = $(this).data("delsubtoken");
             var id = $(this).data("delsubid");
             $.ajax({
                     type: "POST",
                     url: "/admin/subcategories/"+id+"/delete",
                     data: {id: id, token: token},
                     success:(response)=>{
                     var response = jQuery.parseJSON(response);
                      $(".deletesubnotification").css("display", "block").addClass("alert-success").delay(3000).slideUp(300).html(response.success);
                     },
                     error:(errors)=>{
                    $(".deletesubnotification").css("display", "block").addClass("alert-danger").delay(3000).slideUp(300).html("Something happened. Try again or contact support!");
                     }
             })
			e.preventDefault();
		})
	}
})();