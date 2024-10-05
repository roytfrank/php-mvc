@extends('admin.layout')
@section('title', 'Display Admin Payments')
@section('active-page', 'adminAllPayment')
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
		<h5 class="text-secondary mt-3">REJOY PAYMENTS</h5>
      <div class="table-responsive">
@if(isset($users))
	     <table class="table table-stiped">
		  <thead>
		 	<tr>
		 	<th>Buyer</th>
            <th>Order No</th>
            <th>Amount</th>
            <th>Status</th>
		 	<th>Created</th>
		 	<th>Updated</th>
		 </tr>
		 </thead>
		 <tbody>
		 	@foreach($payments as $payment)
		 	<tr>
		     @foreach($users as $user)
		      @if($user->id === $payment->user_id)
		     <td>{{$user->name}}</td>
		     @endif
		    @endforeach
		    <td>{{$payment->order_num}}</td>
		    <td>{{$payment->amount}}</td>
		    <td>{{$payment->status}}</td>
		    <td>{{$payment->created_at}}</td>
		    <td>{{$payment->updated_at}}</td>
		</tr>
		@endforeach
		 </tbody>
	  </table>
@endif
   </div>
  </div>
</div>

@endsection