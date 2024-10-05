(function(){
 "use strict";

 REJOY.admin.createsubcategory = function(){
      $(".addsubCategory").on("click", function(e){
      	var token = $(this).data('subtoken')
        var id = $(this).data('subid');
        var name = $("#subname-"+id).val();
          $.ajax({
          	    type: "POST",
          	    url: "/admin/subcategories/create",
          	    data: {name: name, category_id: id, token: token},
          	    success:(response)=>{
          	    	console.log(response);
                  var response =  jQuery.parseJSON(response);
                  $(".subnotification").css("display", "block").removeClass("alert-danger").addClass("alert-success").delay(3000).slideUp(300).html(response.success);
          	    },
          	    error:(response, errors)=>{
                   console.log(response);
                   var response = jQuery.parseJSON(response.responseText);
                   var ul = document.createElement("ul");
                   $.each(response, function(key, value){
                   	var li = document.createElement("li");
                   	li.appendChild(document.createTextNode(value));
                   	ul.appendChild(li);
                   });
                  $(".subnotification").css("display", "block").removeClass("alert-success").addClass("alert-danger").delay(5000).slideUp(300).html(ul);
          	    }
          });
      	e.preventDefault();
      });
 }

}());