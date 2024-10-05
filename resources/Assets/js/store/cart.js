(function(){
	"use strict";
	REJOY.store.cartpage = function(){
    var Stripe = StripeCheckout.configure({
        key: $("#properties").data("stripe-publishable-key"),
        locale: "auto",
        allowRememberMe: false,
        token : function(token){ //we get a token from stripe
           var data = $.param({ stripeToken: token.id, stripeEmail: token.email});
            axios.post('/cart/payment', data).then((response)=>{
              console.log(response);
            $("#cartnoty").css("display", "block").delay(6000).slideUp(300).html("Thank you for your purchase. Your order is being processed");
              usercart.getcartItems();
          }).catch((error)=>{
             // console.log(error);
          })
        }
    });
		var usercart = new Vue({                    
              el: "#cart",
              data: {
              	cartItems: [],
              	cartTotal: [],
                cartcount: 0,
                amountInCents: 0,
              	fail: false,
                load: false,
               authenticated: false,
              	message: " ",
              },
              methods: {
               getcartItems:function(){
                 this.fail = false;                    
                 setTimeout(function(){
                  axios.get("/cart/items").then((items)=>{
                    if(items.data.fail){
                      usercart.fail = true;
                      usercart.message = items.data.fail;
                    }else{
                     usercart.load = true;
                     usercart.cartItems = items.data.cartItems;
                     usercart.cartTotal = items.data.cartTotal;
                     usercart.authenticated = items.data.authenticated;
                     usercart.amountInCents = items.data.amountInCents;
                   }
                 }); 
               }, 1000);
               },
              updateQty:function(id, operator){
               var data = $.param({product_id: id, operator: operator});
                 axios.post("/cart/update", data).then(function(qtychanged){
                     usercart.getcartItems(100);
                 });
             },
             removeItem: function(index){           
              var data = $.param({index: index});
               axios.post("/cart/remove", data).then((removed)=>{
                  usercart.getcartItems(100);
               })
             },
             checkout:function(){
                 Stripe.open({ //we open the variable we created
                         name: "Rejoy store",
                         description: "Rejoy store shopping cart item",
                         email: $("#properties").data("customer-email"),
                         amount: usercart.amountInCents + (usercart.tax1*100) + (usercart.tax2*100),
                         zipCode: true //require user to provide zipcode
                 });
                 return false;
             },
             paypalCheckout:function(){
                  paypal.Buttons({
                  createOrder: function(data, actions) {
                   return actions.order.create({
                      purchase_units: [{
                        amount: {
                          value: usercart.amountInCents + (usercart.tax1*100) + (usercart.tax2*100),
                        }
                      }]
                    });
                  },
                  onApprove: function(data, actions) {
                    var base_url = $("#baseUrl").data("base_url");
                 return actions.order.capture().then(function(details) {
                 $("#cartnoty").css("display", "block").delay(2000).slideUp(300).html('Transaction completed by ' + details.payer.name.given_name);
                 return fetch(base_url+'/checkout/payment', {
                        method: 'post',
                        headers: {
                        'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                          orderID: data.orderID
                        })
                      });
                    });
                  }
                }).render('#paypal-button-container');              
             },
             stringlimit: function(string, value){
              return REJOY.global.strLimit(string, value);
             }
            },      
             created: function(){
              this.getcartItems();
             },
          computed: {
            tax1(){
              return this.cartTotal * (1/100);
            },
            tax2(){
              return this.cartTotal * (1.5/100);
            },
            total(){
              return this.cartTotal + this.tax1 + this.tax2;
            }
          }, 
          mounted: function(){
            this.paypalCheckout();
          }
		});
	}
})();