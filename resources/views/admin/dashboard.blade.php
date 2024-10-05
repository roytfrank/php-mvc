@extends('admin.layout')
@section('title', 'Admin Dashboard')
@section('active-page', 'dashboard')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-2 p-0 m-0">
          <h5 class="text-secondary">Total Order</h5>
          <div class="card rounded-0 pt-0">
          	<div class="card-body bg-light">
          	<div class="d-flex justify-content-between">
          	   <a href="/rejoy/orders" class="text-decoration-none"><i class = "fa fa-cart-plus fa-fw fa-2x text-primary"></i></a>
          	   @if(isset($orders))
          	   <a href="/rejoy/orders" class="text-decoration-none"><h5>{{$orders}}</h5></a>
          	   @else
          	   <h5>0</h5>
          	   @endif
          	</div>
          	</div>
          </div>
		</div>
		<div class="col-sm-3 p-0 m-0">
          <h5 class="text-secondary">Stock Count</h5>
          <div class="card rounded-0 pt-0">
          	<div class="card-body bg-info">
          	 <div class="d-flex justify-content-between">
          	 	<a href="/admin/products/rejoy" class="text-decoration-none"><i class = "fa fa-bar-chart fa-fw fa-2x text-dark"></i></a>
          	 	 @if(isset($products))
          	   <a href="/admin/products/rejoy" class="text-decoration-none text-dark"><h5>{{$products}}</h5></a>
          	   @else
          	   <h5>0</h5>
          	   @endif
          	 </div>
          	</div>
          </div>
		</div>
		<div class="col-sm-5 p-0 m-0">
          <h5 class="text-secondary">Revenue</h5>
          <div class="card rounded-0 pt-0">
          	<div class="card-body bg-light">
          		<div class="d-flex justify-content-between">
          	    <a href="/rejoy/payments" class="text-decoration-none"><i class="fa fa-money fa-fw fa-2x text-success"></i></a>
          		 @if(isset($payments))
          	   <a href="/rejoy/payments" class="text-decoration-none"><h5>${{number_format($payments/100,2,".", "")}}</h5></a>
          	   @else
          	   <h5>$0.00</h5>
          	   @endif
          		</div>
          	</div>
          </div>
		</div>
		<div class="col-sm-2 p-0 m-0">
          <h5 class="text-secondary">Users</h5>
          <div class="card rounded-0 pt-0">
          	<div class="card-body bg-info">
          	<div class="d-flex justify-content-between">
          		<a href="/rejoy/users" class="text-decoration-none"><i class = "fa fa-users fa-fw fa-2x text-dark"></i></a>
          		 @if(isset($users))
          	   <a href="/rejoy/users" class="text-decoration-none text-dark"><h5>{{$users}}</h5></a>
          	   @else
          	   <h5>0</h5>
          	   @endif
          		</div>
          	</div>
          </div>
		</div>
	</div>
   <div class="row mt-4 mb-5 justify-content-center">
   	<div class="col-sm-4">
    <canvas id="orders" width="300" height="400"></canvas>
   	</div>
   	<div class="col-sm-4">
   <canvas id="revenue" width="300" height="400"></canvas>
   	</div>
   </div>
</div>
@endsection
