@extends('admin.layout')
@section('title', 'Display Admin Users')
@section('active-page', 'adminAllUsers')
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
		<h5 class="text-secondary mt-3">REJOY USERS</h5>
      <div class="table-responsive">
@if(isset($users))
	     <table class="table table-stiped">
		  <thead>
		 	<tr>
		 	<th>Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Avatar</th>
		 	<th>Bio</th>
		 	<th class="text-success">Status</th>
		 	<th>Created</th>
		 	<th>Updated</th>
		 	<th class="text-danger">Remove</th>
		 </tr>
		 </thead>
		 <tbody>
		 	@foreach($users as $user)
		 	<tr>
		    <td>{{$user->name}}</td>
		    <td>{{$user->username}}</td>
		    <td>{{$user->email}}</td>
		    <td>{{$user->avatar}}NULL</td>
		    <td>{{$user->bio}}NULL</td>
		    @if($user->role_id == 56)
		    <td>Admin</td>
		     @elseif($user->role_id == 66)
		    <td>Editor</td>
		     @else($user->role_id == 86)
		    <td>Regular</td>
		    @endif
		    <td>{{$user->created_at}}</td>
		    <td>{{$user->updated_at}}</td>
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