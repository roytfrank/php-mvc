(function(){
	"use strict";
	REJOY.store.singles = function(){
        var theitem = new Vue({
            el: "#theItem",
            data: {
           	similarProducts: [],
           	loading: false,
            count: null,
           },
           methods: {
           	 getproductdetails: function(){
           	 	  this.loading = true;
                var id = $("#theItem").attr("data-code");
              setTimeout(function(){ 
                axios.get("/productdetails/"+id+"/details").then((alldata)=>{
                	  theitem.loading = false;
                    theitem.similarProducts = alldata.data.similarproducts;
                    theitem.count = alldata.data.count;
                });  
              }, 800);           
           	 },
           	 loadmore: function(){
                var similarproducts = localStorage.getItem("similarproducts");
                var number = localStorage.getItem("count");
                if(similarproducts && number == theitem.count)
                {
                   theitem.similarProducts = JSON.parse(similarproducts);
                   return;
                }               
           	 	var id = $("#theItem").attr("data-code");
           	 	var category_id = $("#theItem").attr("data-more");
           	 	var token = $("#theItem").attr("data-token");
                
           	 	var data = $.param({id: id, next: 4, token: token, count: theitem.count, category_id: category_id});         
                axios.post("/loadmore/product/", data).then((moredata)=>{
                    theitem.similarProducts = moredata.data.moresimilarproducts;
                    theitem.count = moredata.data.count;     
                    
                    localStorage.setItem("similarproducts", JSON.stringify(moredata.data.moresimilarproducts));
                    localStorage.setItem("count", JSON.stringify(moredata.data.count));          
                });
           	 }, 
           	 addToCart: function(id){
           	 	var quantity = $("#productQuantity").val();
              REJOY.global.addItemToCart(id, quantity, function(message){
                   $("#cartnoty").css("display", "block").delay(2000).slideUp(300).html(message);
              });              
           	 },
           	 stringlimit: function(string, value){
           	 	return REJOY.global.strLimit(string, value);
           	 }
           },
          created: function(){
          	this.getproductdetails();
          },
          mounted: function(){
          	 $(window).scroll(function(){
                if($(window).scrollTop() + $(window).height() == $(document).height()){
                   	theitem.loadmore();
                }
          	 });
          }
        });
	}
})();