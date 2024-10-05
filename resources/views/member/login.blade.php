@extends('member.layout')
@section('title', 'Login')
@section('active-page', 'loginPage')
@section('content')
<div class="container-fluid">
	<div class="row justify-content-center">
    @if(isset($errors))
      @include('inc.errors')
    @endif
      <div class="col-sm-6 col-md-7 col-lg-4">
       @if(isset($_SESSION['register']['success']))
         @include('inc.success')
        @endif
      	<h4 class="text-secondary mb-3">Login</h4>
      	<div class="card border-0">
              <div class="card-body bg-secondary">
               <form method="post" action="/login" id="login-form">
                  <div class="form-group">
                        <label for="username" class="text-white">Username</label>
                        <input class="form-control bg-light" type="text" name="username" placeholder="Enter Username or Email" id="username">
                  </div>
                  <div class="form-group">
                        <label for="password" class="text-white">Password</label>
                        <input class="form-control bg-light" type="password" name="password" placeholder="Enter Password" id="password">
                  </div>
                  <div class="form-group d-flex justify-content-between">
                       <input type="hidden" name="token" value="{{\App\Classes\CSRFToken::token()}}">
                        <input type="submit" class="btn btn-primary text-dark" name="loginBtn" value="Login" id="loginBtn">
                        <a href="/register" class="font-weight-bold text-decoration-none">Register</a>
                  </div>
                  <div class="form-group">
                    <input type="checkbox" name="remember"><span class='text-white'><em>Remember Me</em></span>
                  </div>
                  <div class="form-group">
                    <a href="javascript:void(0)" class="text-primary text-decoration-none float-right">Forgot Password</a>
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