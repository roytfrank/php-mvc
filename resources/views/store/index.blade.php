@extends('store.layout')
@section('title', 'Rejoy')
@section('active-page', 'home')
@section('content')
<div class="container-fluid mt-4">
	<div class="row">
@if(\App\Classes\Session::has('error'))
      @include('inc.sessionerror')
 @endif
	  <div class="offset-sm-1 col-sm-10">
		<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
              <div class="carousel-item active">
                  <img src="/images/image6.jpg" class="d-block w-100 bg-white" height="320px;" alt="...">
              </div>
              <div class="carousel-item">
                  <img src="/images/image4.jpg" class="d-block w-100 bg-white" height="320px;" alt="...">
              </div>
              <div class="carousel-item">
                  <img src="/images/image2.jpg" class="d-block w-100 bg-white" height="320px;" alt="...">
              </div>
          </div>
       </div>
     </div>
   </div>
</div>
<!--Display-->
<div class="wrapper mt-3 itemsId" id="app">
	<div class="container-fluid" id="productinfo" data-xen="{{\App\Classes\CSRFToken::token()}}">
    <!--Notification for added item-->
    <div class="row">
      <div class="col-sm-12">
         <div class="d-flex justify-content-end mr-4">
           <div class="alert alert-primary" id="cartnoty"></div>
         </div>
      </div>
    </div>
<!--Noty ends-->
    <h4 class="text-secondary">Featured Editions</h4>
		  <div class="row">
      <div class="col-sm-6 col-md-4 col-lg-2 p-0 mx-0 my-3" v-cloak v-for="feature in featured">
        <div class="card border-0 m-1 p-1" v-if="loading == false">
          <!--Item image-->
           <a :href="'/product/'+feature.id+'&'+feature.slug+'<?php echo date('Y&m&d'); ?>'" class="text-decoration-none"><img :src="'/'+feature.image1" height="260px;" class="card-img-top rounded-0" :alt="feature.name"></a>
           <!--Item name and price-->
           <div class="card-body m-0 p-0">
          <a :href="'/product/'+feature.id+'&'+feature.slug+'<?php echo date('Y&m&d'); ?>'" class="text-dark text-decoration-none"><span class="text-primary">@{{stringlimit(feature.name, 22)}}</span><br />Sale Price: $@{{Number(feature.saleprice).toFixed(2)}}</a><br />
          <!--%Off-->
           <a :href="'/product/'+feature.id+'&'+feature.slug+'<?php echo date('Y&m&d'); ?>'" class=" text-decoration-none text-dark"><span v-if="feature.percentoff > 0"><s>Price: $@{{Number(feature.price).toFixed(2)}}</s>&nbsp;@{{feature.percentoff}}%OFF</span><span v-else>Direct Sale</span></a>
           </div>
        </div>
      </div>
		</div>
	</div>
  <div class="container-fluid mt-5">
    <div class="row">
      <div class="offset-sm-1 col-sm-10">
        <div class="text-center">
        <h4 class="text-secondary">NEW PRODUCTS IN STOCK</h4>
       </div>
        <div class="row">
           <div
           v class="col-sm-3 col-md-6 col-lg-3 p-0 mx-0 my-3" v-cloak v-for="product in products">
              <div class="card border-0 m-1 p-1" v-if="loading == false">
                <a :href="'/product/'+product.id+'&'+product.slug+'<?php echo date('Y&m&d'); ?>'" class="text-decoration-none"><img :src="'/'+product.image1" height="200px;" class="card-img-top rounded-0"></a>
                <div class="card-body m-0 p-0">
                   <a :href="'/product/'+product.id+'&'+product.slug+'<?php echo date('Y&m&d'); ?>'" class="text-dark text-decoration-none"><span class="font-weight-bold">@{{stringlimit(product.name, 27)}}</span><br />Sale Price: $@{{Number(product.saleprice).toFixed(2)}}</a><br />
                   <!--%off-->
                   <a :href="'/product/'+product.id+'&'+product.slug+'<?php echo date('Y&m&d'); ?>'" class="text-dark text-decoration-none"><span v-if="product.percentoff > 0">@{{product.percentoff}}%OFF&nbsp;<s>Original: $@{{Number(product.price).toFixed(2)}}</s></span><span v-else>Direct Sale</span></a>
                   <!--Add to cart-->
                   <a href="javascript:void(0)" v-if="product.quantity > 0" @click.prevent = "addToCart(product.id)" class="float-right"><small class="toCart">Add To Cart</small></a>
                   <a href="javascript:void(0)" v-else class="float-right text-decoration-none"><small class="toCart">Out-Of-Stock</small></a>
                   <div class="clearfix"></div>
                </div>
              </div>
           </div>
        </div>
      </div>
    </div>
  </div>
<div v-if="loading" class="text-center">
  <div class="spinner-grow" style="width: 8rem; height: 8rem;" role="status">
     <span class="sr-only">Loading...</span>
   </div>
 </div>
</div>
@stop
@section('footer')
@endsection