@extends('admin.layout')
@section('title', 'Create Admin Products')
@section('active-page', 'adminProduct')
@section('content')
 <div class="card" id="create-product-card">
 	<div class="card-body">
  @if(isset($errors))
     @include('inc.errors')
  @endif
 	<h5 class="text-secondary mb-3">CREATE PRODUCTS</h5>
 		<form action="/admin/products" method="POST" enctype="multipart/form-data">
 			<div class="row">
 			 @if(isset($success))
 	             @include('inc.productsuccess')
 	           @endif
 				<div class="col-sm-4">
 				   <div class="form-group">
 					 <label for="productname" class="font-weight-bold">Product Name</label>
 					 <input class="form-control" type="text" name="name" id="productname" value="{{\App\Classes\Request::old('post', 'name')}}">
 				   </div>
 				</div>
 				<div class="col-sm-4">
 				   <div class="form-group">
 					 <label for="productprice" class="font-weight-bold">Product Price</label>
 					 <input class="form-control" type="number" step="any" min="0" name="price" value="{{\App\Classes\Request::old('post', 'price')}}" id="productprice">
 				   </div>
 				</div>
 				<div class="col-sm-4">
 				   <div class="form-group">
 					 <label for="percentoff" class="font-weight-bold">(%) Percent Off</label>
 					 <input class="form-control" type="number" min="0" name="percentoff" value="{{\App\Classes\Request::old('post', 'percentoff')}}" id="percentoff">
 				   </div>
 				</div>
 			</div>
 			<div class="row">
 				<div class="col-sm-6">
 				   <div class="form-group">
 					 <label for="selectfeatured" class="font-weight-bold">Featured</label>
 					 <select name="featured" class="form-control" id="selectfeatured">
 					 	<option value="{{\App\Classes\Request::old('post', 'featured')?:''}}">{{\App\Classes\Request::old('post', 'featured')?:'Select Featured...'}}</option>
 					 	<option value="Y">Yes</option>
 					 	<option value="N">No</option>
 					 </select>
 				   </div>
 				</div>
 				<div class="col-sm-6">
 				   <div class="form-group">
 					 <label for="selectquantity" class="font-weight-bold">Product Quantity</label>
 					 <input type="number" class="form-control" min="0" name="quantity" id="selectquantity" value="{{\App\Classes\Request::old('post', 'quantity')?:''}}">
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
 					 <label for="productcategory" class="font-weight-bold">Category</label>
 					 <select name="category" class="form-control" id="productcategory">
 					 	<option value="">Select Category...</option>
 					 	@foreach($categories as $category)
 					 	<option value="{{$category->id}}">{{$category->name}}</option>
 					 	@endforeach
 					 </select>
 				   </div>
 				</div>
 				<div class="col-sm-6">
 				   <div class="form-group">
 					 <label for="productsubcategory" class="font-weight-bold">SubCategory</label>
 					 <select name="subcategory" class="form-control" id="productsubcategory">
 					 	<option value="">Select SubCategory...</option>
 					 </select>
 				   </div>
 				</div>
 			</div>
 			<div class="row">
 				<div class="col-sm-6">
 				   <div class="form-group" class="font-weight-bold">
 					 <label for="product" class="font-weight-bold">Product Description</label>
 					 <textarea class="form-control" name="description"  rows="6" id="product">{{\App\Classes\Request::old('post', 'description')?:''}}</textarea>
 				   </div>
 				</div>
 				<div class="col-sm-6">
 				   <div class="form-group">
 					 <label for="available" class="font-weight-bold">Available Date</label>
 					 <input class="form-control" type="date" name="saledate" value="{{\App\Classes\Request::old('post', 'saledate')?:''}}" id="available">
 				   </div>
 				</div>
 			</div>
 			<div class="row justify-content-center">
 				<div class="col-sm-4">
 				   <div class="form-group" class="font-weight-bold">
 				   	<input type="hidden" name="token" value="{{\App\Classes\CSRFToken::token()}}">
 					<input type="submit" class="form-control btn-success font-weight-bold text-dark" name="submitProduct" value="Create Product">
 				   </div>
 				</div>
 			</div>
 		</form>
 	</div>
 </div>
@endsection