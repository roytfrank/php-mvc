@extends('member.layout')
@section('title', 'Register')
@section('active-page', 'registerPage')
@section('content')
<div class="container-fluid mb-5">
	<div class="row justify-content-center">
    @if(isset($errors))
      @include('inc.errors')
    @endif
      <div class="col-sm-4 col-md-6 col-lg-4">
      	<h4 class="text-secondary mb-3">Register</h4>
      	<div class="card border-0">
             <div class="card-body bg-secondary">
               <form method="post" action="/register" id="login-form">
                  <div class="form-group">
                        <label for="name" class="text-white">Name</label>
                        <input class="form-control" type="text" name="name" placeholder="Enter Name" value="{{\App\Classes\Request::old('post', 'name')}}" id="name">
                  </div>
                  <div class="form-group">
                        <label for="email" class="text-white">Email</label>
                        <input class="form-control bg-light" type="text" name="email" placeholder="Enter Email" id="email" autocomplete="off">
                  </div>
                  <div class="form-group">
                        <label for="username" class="text-white">Username</label>
                        <input class="form-control" type="text" name="username" placeholder="Enter Username" value="{{\App\Classes\Request::old('post', 'username')}}" id="username">
                  </div>
                  <div class="form-group">
                        <label for="password" class="text-white">Password</label>
                        <input class="form-control bg-light" type="password" name="password" placeholder="Enter Password" id="password" autocomplete="off">
                  </div>
                  <div class="form-group">
                        <label for="confirm_password" class="text-white">Confirm Password</label>
                        <input class="form-control" type="password" name="confirm_password" placeholder="Enter Confirm Password" id="confirm_password" autocomplete="off">
                  </div>
                  <div class="form-group d-flex justify-content-between">
                       <input type="hidden" name="token" value="{{\App\Classes\CSRFToken::token()}}">
                        <input type="submit" class="btn btn-primary" name="registerBtn" value="Register" id="registerBtn">
                        <a href="/login" class="font-weight-bold text-decoration-none">Login</a>
                  </div>
                </form>
             </div>
            </div>
         </div>
    </div>
</div>
@endsection
@section('footer')
@stop