(function(){
  "use strict";
  REJOY.admin.deleteproduct = function(){
  	 $(".trashData").on("click", function(e){
       var product_id = $(this).attr("data-trash");   
         $.ajax({
         	  type: "POST",
         	  url: "/admin/products/delete",
         	  data:{id: product_id},
         	  success:(data)=>{
              var data = jQuery.parseJSON(data);
              if(data.success === 56200){
              alert("Product removed successfully");      
              }else{ alert("Request not processed. Please try again"); }
         	  }, 
         	  error:(response)=>{
               alert("Something happened. Try again or contact support!");
         	  },
            complete:()=>{
              location.reload();
            }
         });
e.preventDefault();
  	 });
  }

})();