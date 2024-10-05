(function(){
   "use strict";
	REJOY.global = {
		  strLimit: function(string, value){
		 	if(string.length > value){
		 		return string = string.substring(string, value)+"...";
		 	}else{ return string; }
		 },
		addItemToCart: function(id, quantity, callback){
              var token = $("#productinfo").attr("data-xen");
                  var qty = 0;
             if(quantity > 0) { qty = quantity }else{ qty = 1 }            
             var data = $.param({product_id: id, token: token, quantity: qty});
              axios.post("/addcartitem", data).then((message)=>{
                      callback(message.data.success);
            });
		}
	}	
})();