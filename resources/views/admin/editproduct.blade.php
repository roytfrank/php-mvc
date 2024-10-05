@extends('admin.layout')
@section('title', 'Edit Admin Products')
@section('active-page', 'adminProductEdit')
@section('content')
 <div class="card" id="create-product-card">
 	<div class="card-body">
 	@if(isset($errors))
 	  @include('inc.errors')
 	@endif
 	@if(isset($product))
  <h5 class="text-secondary mb-3">EDIT PRODUCTS</h5>
 		<form action="/admin/products/{{$product->id}}/update" method="POST" enctype="multipart/form-data">
 			<div class="row">
 				@if(isset($success))
 	                @include('inc.productsuccess')
 	             @endif
 				<div class="col-sm-4">
 				   <div class="form-group">
 					 <label for="name" class="font-weight-bold">Product Name</label>
 					 <input class="form-control" type="text" name="name" id="productname" value="{{$product->name}}">
 				   </div>
 				</div>
 				<div class="col-sm-4">
 				   <div class="form-group">
 					 <label for="productprice" class="font-weight-bold">Product Price</label>
 					 <input class="form-control" type="number" min="0" name="price" value="{{$product->price}}" id="productprice">
 				   </div>
 				</div>
 				<div class="col-sm-4">
 				   <div class="form-group">
 					 <label for="productprice" class="font-weight-bold">(%) Percent Off</label>
 					 <input class="form-control" type="number" min="0" name="percentoff" value="{{$product->percentoff}}" id="product">
 				   </div>
 				</div>
 			</div>
 			<div class="row">
 			    <div class="col-sm-6">
 				   <div class="form-group">
 					 <label for="productimage" class="font-weight-bold">Image1</label>
 					 <input class="form-control" type="file" name="image1" id="productimage">
 				   </div>
 				</div>
 			    <div class="col-sm-6">
 				   <div class="form-group">
 					 <label for="productimage" class="font-weight-bold">Image2</label>
 					 <input class="form-control" type="file" name="image2" id="productimage">
 				   </div>
 			   </div>
 			</div>
 			<div class="row">
 				<div class="col-sm-6">
 				   <div class="form-group">
 					 <label for="productimage" class="font-weight-bold">Image3</label>
 					 <input class="form-control" type="file" name="image3" id="productimage">
 				   </div>
 				</div>
 			    <div class="col-sm-6">
 				   <div class="form-group">
 					 <label for="productimage" class="font-weight-bold">Image4</label>
 					 <input class="form-control" type="file" name="image4" id="productimage">
 				   </div>
 			   </div>
 			</div>
 			<div class="row">
 				<div class="col-sm-6">
 				   <div class="form-group">
 					 <label for="featured" class="font-weight-bold">Featured</label>
 					 <select name="featured" class="form-control" id="selectfeatured">
 					 	<option value="Y" @if($product->featured === "Y") "selected" @endif>Yes</option>
 					 	<option value="N" @if($product->featured === "N") "selected" @endif>No</option>
 					 </select>
 				   </div>
 				</div>
 				<div class="col-sm-6">
 				   <div class="form-group">
 					 <label for="quantity" class="font-weight-bold">Product Quantity</label>
 					 <input type="number" class="form-control" min="0" name="quantity" id="selectquantity" value="{{$product->quantity}}">
 				   </div>
 				</div>
 			</div>
 			<div class="row">
 				<div class="col-sm-6">
 				   <div class="form-group">
 					 <label for="productcategory" class="font-weight-bold">Category</label>
 					 <select name="category" class="form-control" id="productcategory">
 					 	@foreach($categories as $category)
 					 	<option value="{{$category->id}}" @if($category->id === $product->category_id) "selected" @endif>{{$category->name}}</option>
 					 	 @endforeach
 					 </select>
 				   </div>
 				</div>
 				<div class="col-sm-6">
 				   <div class="form-group">
 					 <label for="subcategory" class="font-weight-bold">SubCategory</label>
 					 <select name="subcategory" class="form-control" id="productsubcategory">
 					 <option value="{{$product->sub_category_id}}">{{$product->subcategory->name}}</option>
 					 </select>
 				   </div>
 				</div>
 			</div>
 			<div class="row">
 				<div class="col-sm-6">
 				   <div class="form-group" class="font-weight-bold">
 					 <label for="product" class="font-weight-bold">Product Description</label>
 					 <textarea class="form-control" name="description"  rows="6" id="product">{{$product->description}}</textarea>
 				   </div>
 				</div>
 				<div class="col-sm-6">
 				   <div class="form-group">
 					 <label for="available" class="font-weight-bold">Available Date</label>
 					 <input class="form-control" type="date" name="saledate" value="{{$product->saledate}}" id="available">
 				   </div>
 				</div>
 			</div>
 			<div class="row justify-content-center">
 				<div class="col-sm-4">
 				   <div class="form-group" class="font-weight-bold">
 				   	<input type="hidden" name="token" value="{{\App\Classes\CSRFToken::token()}}">
 				   	<input type="hidden" name="id" value="{{$product->id}}">
 					<input type="submit" class="form-control btn-success font-weight-bold text-dark" name="editProduct" value="Update Product">
 				   </div>
 				</div>
 			</div>
 		</form>
 		@else
 		<h5>Product Not Found</h5>
 		@endif
 	</div>
 </div>
@stop