(function(){
	"use strict";
	REJOY.admin.editsubcategory = function(){
		$(".editsubCategory").on("click", function(e){         
           var token = $(this).data("editsubtoken");
           var id = $(this).data("editsubid");
           var name = $("#newsubname-"+id).val();
           var category_id = $("#subcategory-category-"+id).val();
           $.ajax({
                	type:"POST",
                	url: "/admin/subcategories/"+id+"/update",
                	data: {id: id, token: token, name: name, category_id: category_id},
                	success: (response)=>{
                      var response = jQuery.parseJSON(response);
                      $(".editsubnotification").css("display", "block").removeClass("alert-danger").addClass("alert-success").delay(3000).slideUp(300).html(response.success);
                	},
                	error:(errors)=>{
                	  var errors = jQuery.parseJSON(errors.responseText);
                 	  var ul = document.createElement("ul");
                	  $.each(errors, function(key, value){
                	  	var li = document.createElement("li");
                	  	li.appendChild(document.createTextNode(value));
                	  	ul.appendChild(li);
                	  });
               	 $(".editsubnotification").css("display", "block").removeClass("alert-success").addClass("alert-danger").delay(3000).slideUp(300).html(ul);
               },
               complete:()=>{
               }
           });
        e.preventDefault();
		})
	}
})();