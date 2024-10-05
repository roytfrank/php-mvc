(function(){
 "use strict";
    REJOY.admin.producttoavailable = function(){
		$(".toavailable").on("click", function(e){    
         var product_id = $(this).attr("data-toavailable");
           $.ajax({
           	    type:"POST",
           	    url:"/admin/products/toavailable",
           	    data: {id: product_id},
           	    success:(response)=>{
                 alert("Change to Available is Successful");
           	    },
           	    error:(errors)=>{
                alert("Something Happened. Try again or contact support!");
           	   },
            complete:()=>{
              location.reload();
           }
           });         
			e.preventDefault();
		});
	}
})();