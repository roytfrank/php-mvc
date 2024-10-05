(function(){
  "use strict";
   REJOY.store.featured = function(){   
       var app = new Vue({     
                el: "#app",
                data: {
                	featured: [],
                  products:[],
                	loading: false,
                },
                methods: {
                	getFeaturedProducts: function(){
                        this.loading = true;
                		setTimeout(function(){
                    axios.all([axios.get("/featured"), axios.get("/products")]).then(axios.spread(function(response, data){
                      app.featured = response.data.featured;
                      app.products = data.data.products;
                      app.loading = false;             
                		}));
                  }, 800);                      
                  },
                  addToCart: function(id){
                    var quantity = 0;
                    REJOY.global.addItemToCart(id, quantity, function(message){
                     $("#cartnoty").css("display", "block").delay(2000).slideUp(300).html(message);
                    });
                  },
                	stringlimit: function(string, value){
                    return  REJOY.global.strLimit(string, value);
                    }
                },
                created: function(){
                	this.getFeaturedProducts();
                }
        });
   }
})();