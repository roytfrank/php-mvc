(function(){
	'use strict';
    REJOY.admin.update = function(){
    	//update category
      $(".updateCategory").on("click", function(e){     
        var token = $(this).data('token');
      	var id = $(this).attr("id");
      	var categoryname = $("#name-"+id).val();
      	$.ajax({
      		type: "POST",
      		url: "/admin/categories/"+id+"/update",
      		data: {id:id, token:token, name:categoryname},
      		success: (response)=>{
      			var response = jQuery.parseJSON(response);
      			$(".updatenotification").css("display", "block").addClass("alert-success").delay(3000).slideUp(300).html(response.success);
      		},
      		error:(errors, error)=>{
      			var errors = jQuery.parseJSON(errors.responseText);
              var ul = document.createElement("ul");
      		   $.each(errors, function(key, value){
                var li = document.createElement("li");
                li.appendChild(document.createTextNode(value));
                ul.appendChild(li);
      		   })
      		  $(".updatenotification").css("display", "block").addClass("alert-danger").delay(5000).slideUp(300).html(ul);
      		}
      	});
   e.preventDefault();
      });
    }

})();