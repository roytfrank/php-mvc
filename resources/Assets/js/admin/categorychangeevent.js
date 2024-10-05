(function(){
  'use strict';  
   REJOY.admin.categorychangeevent = function(){
     $("#productcategory").on("change", function(){
       var category_id = $("#productcategory"+" option:selected").val();
       $("#productsubcategory").html('Select SubCategory...'); //must be the same as in template
         $.ajax({
         	  type: "GET",
         	  url: "/admin/products/category/"+category_id+"/subcategories",
         	  data:{category_id: category_id},
         	  success:(response)=>{
                 var response = jQuery.parseJSON(response);
                if(response.length > 0){
                    $.each(response, function(key, value){               	
                    	$("#productsubcategory").append('\
                 		<option value="'+value.id+'">'+value.name+'</option>');
                    })
                 }else{
                 	$("#productsubcategory").append(`
                 		<option value=''>No SubCategory Found</option>`);
                 }
         	  },
         	  error:(response)=>{
                $("#productsubcategory").append(`
                 		<option value=''>Contact Support</option>`);
         	  }
         });
     });
   }    
}());