@extends('store.layout')
@section('title', 'View Product')
@section('active-page', 'singleProduct')
@section('content')
 <div class="mian group" v-cloak id="theItem" data-code="{{$product->id}}" data-token="{{$token}}" data-more="{{$product->category_id}}">
 	<div class="container-fluid mt-5" id="singlebox">
       <div class="row">
      <div class="col-sm-12">
         <div class="d-flex justify-content-end mr-4">
           <div class="alert alert-primary" id="cartnoty"></div>
         </div>
      </div>
       	 <div class="offset-sm-1 col-sm-10">
       	 	 <div class="row">
       	 	 	<div class="col-sm-5">
                  <!--Product Image-->
                  <div class="row">
                  	<div class="col-sm-12 p-0 m-0">
                       <img src="/{{$product->image1}}" class="img-fluid shadow-sm rounded-0" id="mainImage">
                  	</div>
                  </div>
                  <!--Added Images-->
                  <div class="row">
                  	<div class="col col-sm-3 p-0 m-0">
                      <img src="/{{$image->image1}}" class="img-fluid shadow-sm rounded-0 mt-2" id="supportiveImages">
                  	</div>
                  	<div class="col col-sm-3 p-0 m-0">
                      <img src="/{{$image->image2}}" class="img-fluid shadow-sm rounded-0 mt-2" id="supportiveImages">
                  	</div>
                  	<div class="col col-sm-3 p-0 m-0">
                       <img src="/{{$image->image3}}" class="img-fluid shadow-sm rounded-0 mt-2" id="supportiveImages">
                  	</div>
                  	<div class="col col-sm-3 p-0 m-0">
                      <img src="/{{$image->image4}}" class="img-fluid shadow-sm rounded-0 mt-2" id="supportiveImages">
                  	</div>
                  </div>
       	 	 	</div>
       	 	 	<div class="col-sm-7 p-0 m-0">
                   <div class="card border-0 infosection">
                   	 <div class="card-body">
                   	 	<h4 class="text-secondary p-0 m-0">{{$product->name}}</h4>
                   	 	<hr />
                   	 	<div class="card-body p-0 m-0">
                   	 		<!--product quantity-->
                   	 		<label>
                   	 			Quantity
                   	 			<select class="form-control" id="productQuantity">
                   	 		@if($product->quantity <= 0)
                   	 			<option value="">0</option>
                   	 	    @else
                       	   	  	@for($i=1; $i<=$product->quantity; $i++)
                       	   	  		<option value="{{$i}}">{{$i}}</option>
                       	   	  	@endfor
                       	   	@endif
                   	 			</select>
                   	 		</label>
                   	 		<!--productprice-->
                   	 		@if($product->percentoff <= 0)
                       	   	  <p>Best Price, Best Offer!</p>
                       	   	  @else
                   	 		<p class="display-5"><del class="mr-2">Original Price: ${{number_format($product->price, 2, ".", "")}}</del>&nbsp;<span class="amountoff">{{$product->percentoff}}%OFF</span></p>
                   	 		@endif
                              <p class="display-5">Now Price: ${{number_format($product->saleprice, 2, ".", "")}}</p>
                              <div class="d-flex justify-content-between ml-3">
                              	<!--Buy Now button-->
                            @if($product->quantity <= 0)
                               <button disabled class="btn btn-sm btn-success text-dark font-weight-bold p-0 m-0" title="Product Unavailable">Out-Of-Stock</button>
                               @else
                               <button class="btn btn-sm btn-success text-dark font-weight-bold p-0 m-0">Buy Now</button>
                            @endif
                               <!--Add To Cart Button-->
                            @if($product->quantity <= 0)
                              	&nbsp;<button  disabled class="btn btn-sm btn-primary text-dark font-weight-bold p-0 m-0" title="Availability"><em>Available On: {{$product->saledate}}</em></button>
                            @else
                               <button  @click.prevent="addToCart({{$product->id}})"class="btn btn-sm btn-primary text-dark font-weight-bold p-0 m-0">Add To Cart</button>
                            @endif
                              </div>
                              <div class="paymentmethod text-center mt-2">
                                <i class="fa fa-cc-paypal fa-2x" aria-hidden="true"></i>
                                <i class="fa fa-cc-visa fa-2x" aria-hidden="true"></i>
                                <i class="fa fa-cc-mastercard fa-2x" aria-hidden="true"></i>
                              </div>
                   	 	</div>
                   	 </div>
                   </div>
                  <div class="accordion" id="rejoyaccordion">
                 <div class="card rejoydesc">
                 <div class="card-header" id="headingOne">
                  <h2 class="mb-0">
                    <button class="btn btn-link font-weight-bold text-secondary" type="button" data-toggle="collapse" data-target="#rejoycollapseOne" aria-expanded="true" aria-controls="collapseOne">
                   CLICK FOR PRODUCT DESCRIPTION
               </button>
             </h2>
           </div>
           <div id="rejoycollapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#rejoyaccordion">
           <div class="card-body">
        <nav aria-label="breadcrumb">
         <ol class="breadcrumb  bg-white p-0 m-0">
           <li class="breadcrumb-item font-weight-bold">{{$product->name}}</li>
           <li class="breadcrumb-item font-weight-bold"><a href="">{{$product->category->name}}</a></li>
           <li class="breadcrumb-item font-weight-bold"><a href=""> {{$product->subCategory->name}}</a></li>
         </ol>
       </nav>
       <p class="display-5 p-0">{{$product->description}}</p>
      </div>
    </div>
  </div>
  </div>
       	 	 	</div>
       	 	 </div>
       	 </div>
       </div>
 	</div>
 <!--Spinner Preloader-->
 <div v-if="loading" class="text-center">
  <div class="spinner-grow" style="width: 8rem; height: 8rem;" role="status">
     <span class="sr-only">Loading...</span>
   </div>
 </div>
 <!--End spinner-->
 <div class="container-fluid mt-2" id="productinfo" data-xen="{{$token}}">
  <h4 class="text-secondary">Similar Products</h4>
 	<div class="row">
 		<div class="col-sm-1">
 	     </div>
           <div class="col-sm-3 col-md-6 col-lg-3 p-0 mx-0 my-3" v-cloak v-for="product in similarProducts">
              <div class="card border-0 m-1 p-1" v-if="loading == false">
             <!--Card image-->
                <a :href="'/product/'+product.id+'&'+product.slug+'<?php echo date('Y&m&d'); ?>'" class="text-decoration-none"><img :src="'/'+product.image1" height="200px;" class="card-img-top rounded-0"></a>
                <!--Card body-->
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
@endsection
@section('footer')
@stop