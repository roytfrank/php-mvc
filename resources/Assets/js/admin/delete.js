(function(){
   "use strict";
	REJOY.admin.delete = function(){
		$(".deleteCategory").on("click", function(e){            
            var token = $(this).data("deltoken");
			var id = $(this).data("id");
			$.ajax({
				  type: "POST",
				  url: "/admin/categories/"+id+"/delete",
				  data: {id: id, token: token},
				  success: (response)=>{
                    var response = jQuery.parseJSON(response);
                    $(".deletenotification").css("display", "block").addClass("alert-success").delay(3000).slideUp(300).html(response.success);
				  },
				  error:(errors)=>{
                   $(".deletenotification").css("display", "block").addClass("alert-danger").delay(5000).slideUp(300).html("Something happened. Try again or contact support!");
				  }
			})
	e.preventDefault();
		});
	}
}());