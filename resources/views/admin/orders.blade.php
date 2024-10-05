@extends('admin.layout')
@section('title', 'Display Admin Order')
@section('active-page', 'adminAllOrders')
@section('content')
<div class="card">
	<div class="card-body" id="product-table-card">
		<div class="row justify-content-center">
			<div class="col-sm-6">
			 <form>
			 	<div class="input-group">
			 		<input type="text" class="form-control productsearch" name="search" value="" placeholder="Search Here">
			 		<div class="input-group-prepend">
			 			<input type="submit" class="btn-primary" name="searchButton" value="Search">
			 		</div>
			 	</div>
			 </form>
			</div>
		</div>
<div class="removenotification"></div>
@if(isset($success))
  @include('inc.productsuccess')
@endif
		<h5 class="text-secondary mt-3">REJOY ORDERS</h5>
      <div class="table-responsive">
@if(isset($orders))
	     <table class="table table-stiped">
		  <thead>
		 	<tr>
		 	<th>Order No.</th>
            <th>Stripe/Paypal Id</th>
            <th>Product</th>
            <th>Buyer</th>
		 	<th>Sale Price</th>
		 	<th>Total</th>
		 	<th>Quantity</th>
		 	<th>Status</th>
		 	<th>Created</th>
		 	<th>Updated</th>
		 	<th>Edit</th>
		 	<th>Remove</th>
		 </tr>
		 </thead>
		 <tbody>
		 	@foreach($orders as $order)
		 	<tr>
		    <td>{{$order->order_num}}</td>
		    <td>{{$order->customer}}</td>
		    @foreach($products as $product)
		      @if($product->id === $order->product_id)
		    <td>{{$product->name}}</td>
		    @endif
		   @endforeach
		    @foreach($users as $user)
		      @if($user->id === $order->user_id)
		    <td>{{$user->name}}</td>
		    @endif
		   @endforeach
		    <td>{{$order->item_price}}</td>
		    <td>{{$order->total}}</td>
            <td>{{$order->quantity}}</td>
            <td>{{$order->status}}</td>
            <td>{{$order->created_at}}</td>
            <td>{{$order->updated_at}}</td>
            <td><a href="javascript:void(0)" class="text-warning"><i class="fa fa-edit fa-fw" aria-hidden="true"></i></a>
            </td>
		    <td>
             <a href="javascript:void()" class="text-danger" ><i class="fa fa-trash fa-fw" aria-hidden="true"></i></a>
		 	</td>
		</tr>
		@endforeach
		 </tbody>
	  </table>
@endif
   </div>
  </div>
</div>

@endsection