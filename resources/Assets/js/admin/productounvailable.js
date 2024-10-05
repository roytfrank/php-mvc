(function(){
  "use strict";
	REJOY.admin.productounavailable = function(){
		$(".tounavailable").on("click", function(e){    
         var product_id = $(this).attr("data-tounavailable");
           $.ajax({
           	    type:"POST",
           	    url:"/admin/products/tounavailable",
           	    data: {id: product_id},
           	    success:(response)=>{
                  alert("Change to Unavailable is Successful");
           	    },
           	    error:(errors)=>{
                alert("Somthing happened. Try again or contact support!");
           	   },
              complete:()=>{
              location.reload();
           }
           });
			e.preventDefault();
		});
	}

})();