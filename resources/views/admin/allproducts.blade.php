@extends('admin.layout')
@section('title', 'Display Admin Products')
@section('active-page', 'adminAllProducts')
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
		<h5 class="text-secondary mt-3">ACTIVE PRODUCTS</h5>
      <div class="table-responsive">
@if(isset($products))
	     <table class="table table-stiped">
		  <thead>
		 	<tr>
		 	<th>Image</th>
		 	<th>Name</th>
            <th>Price</th>
            <th>% Off</th>
            <th>SalePrice</th>
		 	<th>Category</th>
		 	<th>SubCategory</th>
		 	<th>Featured</th>
		 	<th>Quantity</th>
		 	<th>SaleDate</th>
		 	<th class="text-success">Status</th>
		 	<th>PostedBy</th>
		 	<th>Description</th>
		 	<th class="text-warning">Edit</th>
		 	<th>Created</th>
		 	<th>Updated</th>
		 	<th class="text-danger">Remove</th>
		 </tr>
		 </thead>
		 <tbody>
		@foreach($products as $product)
		 	<tr>
		 	<td><img src="/{{$product->image1}}" height="60px;" width="90px;"></td>
		 	<td>{{$product->name}}</td>
            <td>{{$product->price}}</td>
            <td>{{$product->percentoff}}</td>
            <td>{{$product->saleprice}}</td>
            @foreach($categories as $category)
              @if($category->id === $product->category_id)
		 	<td>{{$category->name}}</td>
		 	  @endif
		 	@endforeach
		<!--subCategory-->
		    @foreach($subcategories as $subcategory)
              @if($subcategory->id === $product->sub_category_id)
		 	<td>{{$subcategory->name}}</td>
		 	  @endif
		 	@endforeach
		 	<td>{{$product->featured}}</td>
		 	<td>{{$product->quantity}}</td>
		 	<td>{{$product->saledate}}</td>
		 	@if($product->status === "Available")
		 	<td>
		 		<a href="javascript:void(0)" id="tounavailable-{{$product->id}}" class="text-success tounavailable"  data-tounavailable ="{{$product->id}}">{{$product->status}}</a>
		 	</td>
		 	@else
		 	<td>
		 		<a href="javascript:void(0)" id="toavailable-{{$product->id}}" class="text-danger toavailable" data-toavailable="{{$product->id}}">{{$product->status}}</a>
		 	</td>
		 	@endif
		 <!--Posted by user-->
		    @foreach($users as $user)
              @if($user->id === $product->user_id)
		 	<td>{{$user->name}}</td>
		 	  @endif
		 	@endforeach
		 	<td class="description">{{str_limit($product->description, 30, '...')}}</td>
		 	<td><a href="/admin/products/{{$product->id}}/edit" class="text-warning"><i class="fa fa-edit fa-fw" aria-hidden="true"></i></a></td>
		 	<td>{{$product->created_at}}</td>
		 	<td>{{$product->updated_at}}</td>
		 	<td>
             <a href="javascript:void()" id="trashData-{{$product->id}}" class="text-danger trashData"data-trash="{{$product->id}}"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></a>
		 	</td>
		 	</tr>
		 @endforeach
		 </tbody>
	  </table>
	  {!! $links !!}
@endif
   </div>
  </div>
</div>

@endsection