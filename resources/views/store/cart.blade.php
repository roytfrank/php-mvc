@extends('store.layout')
@section('title', 'Items Cart')
@section('active-page', 'cartItems')
@section('checkouts')
<script src="https://checkout.stripe.com/checkout.js"></script>
<script src="https://www.paypal.com/sdk/js?client-id={{getenv('PAYPAL_CLIENT')}}"></script>
@endsection
@section('content')
  <div class="container-fluid mt-5" id="cart">
    <!--Notification for added item-->
    <div class="row">
      <div class="col-sm-12">
         <div class="d-flex justify-content-end mr-4">
           <div class="alert alert-primary" id="cartnoty"></div>
         </div>
      </div>
    </div>
<!--Noty ends-->
  	<div class="row">
      <div id="testButton"></div>
     <h4 class = "font-weight-bold" v-if="fail" v-text="message"></h4>
  		<div class="offset-sm-1 col-sm-10" v-else>
        <h4 class="text-secondary">Cart Details</h4>
  			<div class="row">
  				<div class="col-sm-11">
  					<div class="table-responsive">
  			          <table class="table table-striped">
  						<thead>
  							<tr>
  								<th>Image</th>
                  <th>Product Name</th>
  								<th>Description</th>
  								<th>Price</th>
  								<th>%OFF</th>
  								<th>Sale Price</th>
  								<th>Order Qty</th>
  								<th>Total</th>
                  <th>Action</th>
  							</tr>
  						</thead>
  						<tbody v-if="load">
                <tr v-cloak v-for="item in cartItems">
  							<td><img :src="'/'+item.image" height="60px;" width="70px;"></td>
  							<td>@{{item.name}}</td>
                <td><a :href="'/product/'+item.id+'&'+item.slug+'<?php echo date('Y&m&d'); ?>'" class="text-decoration-none">@{{ stringlimit(item.description, 20)}}</a></td>
  							<td>$@{{Number(item.price).toFixed(2)}}</td>
  							<td>@{{item.percentoff}}%</td>
  							<td>$@{{Number(item.saleprice).toFixed(2)}}</td>
  							<td>
                  @{{item.buyer_quantity}}<br />
                   <a href="javascript:void(0)" @click="updateQty(item.id, '+')" class="text-success" v-if="item.quantity > item.buyer_quantity"><i class="fa fa-plus-square"></i></a> <a href="javascript:void(0)" v-if="item.quantity <= item.buyer_quantity">Left &nbsp;</a>
                  <a href="javascript:void(0)" @click="updateQty(item.id, '-')" class="text-warning" v-if="item.buyer_quantity"><i class="fa fa-minus-square"></i></a>
                </td>
  							<td>
                  $@{{Number(item.totalPrice).toFixed(2)}}
                </td>
                <td>
                <a href="javascript:void(0)" @click="removeItem(item.item_index)" class="text-danger"><i class="fa fa-times"></i></a>
              </td>
  						   </tr>
  						</tbody>
  					</table>
  				  </div>
  				</div>
        </div>
        <div class="row justify-content-center mb-5">
          <div class="col-sm-5">
            <table>
                <tr>
                  <div class="input-group">
                     <input type="text" class="form-control" name="coupon" id="coupon" placeholder="Enter Coupon">
                     <div class="input-group-append">
                     <input type="submit" class="btn btn-sm btn-success font-weight-bold" value="Add Coupon">
                    </div>
                  </div>
                </tr>
                @if(user())
                <tr>
                   <div class="float-right mt-5" id="paypal-button-container"></div>
                </tr>
                <span id="baseUrl" data-base_url = "{{getenv('APP_URL')}}"></span>
                @endif
            </table>
          </div>
  				<div class="col-sm-4">
                  <ul class="list-group">
                   <li class="list-group-item d-flex justify-content-between align-items-center"><span class="font-weight-bold">SubTotal</span>
                      <span class="text-dark">$@{{Number(cartTotal).toFixed(2)}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"><span class="font-weight-bold">Tax 1</span>
                      <span class="text-dark">$@{{Number(tax1).toFixed(2)}}</span>
                    </li>
                     <li class="list-group-item d-flex justify-content-between align-items-center"><span class="font-weight-bold">Tax 2</span>
                      <span class="text-dark">$@{{Number(tax2).toFixed(2)}}</span>
                    </li>
                     <li class="list-group-item d-flex justify-content-between align-items-center"><span class="font-weight-bold">TOTAL</span>
                      <span class="text-dark">$@{{Number(total).toFixed(2)}}</span>
                    </li>
                  </ul>
                  <div class="d-flex justify-content-between mt-1">
                  	<a href="/" class="text-info font-weight-bold text-decoration-none">Continue Shopping</a>
                      <span id="properties" data-customer-email="{{user()->email}}" data-stripe-publishable-key = "{{App\Classes\Session::get('publishable_key')}}">
                    </span>
                    <a href="javascript:void()" v-if="authenticated">
                      <button @click.prevent="checkout()" class="btn btn-success font-weight-bold">Checkout</button>
                    </a>
                  	<a href="/login" v-else><button class="btn btn-success font-weight-bold">Checkout</button>
                    </a>
                  </div>
              </div>
            </div>
  		  </div>
  	</div>
  </div>
@endsection