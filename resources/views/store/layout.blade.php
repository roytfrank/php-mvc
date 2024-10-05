<?php $categories = \App\Models\Category::with('subCategories')->get();?>
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
     <title>REJOY @yield('title')</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
  <script src="https://use.fontawesome.com/9bc7c468ee.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
</head>
<body data-template-id="@yield('active-page')">
   <div class="container-fluid bg-dark fixed-top" id="store-nav">
     <div class="container bg-light bg-secondary">
        <nav class="navbar navbar-expand-md navbar-light bg-secondary">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand text-white" href="/"><strong>REJOY</strong><small><em>store</em></small></a>
    <a class="nav-link d-sm-block d-md-none text-light" href="/cart">Cart&nbsp;<i class="fa fa-cart-plus"></i></a>
   <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link d-none d-md-block text-light" href="/cart">Cart
          <span class="position-absolute text-danger ml-1 font-weight-bold">
          </span><i class="fa fa-cart-plus">
        </i></a>
       </li>
        @if(isAuthenticated() && \App\Classes\Session::has('is_logged_in_user'))
       <li class="nav-item">
        <a class="nav-link text-dark mr-1" href="javascript:void(0)"><i class="fa fa-bell" aria-hidden="true">&nbsp;</i><span class="badge badge-secondary text-danger">0</span></a>
       </li>
         @endif
       <strong class="d-none d-md-inline mt-2 text-dark">|</strong>
       <li class="nav-item dropdown">
        <a class="nav-link text-white" href="javascript:void(0)" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Member
        </a>
        <div class="dropdown-menu rounded-0 bg-secondary" aria-labelledby="navbarDropdow" id="memberdropdown">
          @if(isAuthenticated() && \App\Classes\Session::has('is_logged_in_user'))
            @if(user()->role_id == "56" || user()->role_id == "66")
          <a class="nav-link text-white" href="/admin/dashboard"><i class="fa fa-tachometer fa-fw"></i>Dashboard</a>
            @endif
          <a class="dropdown-item text-light" href="javascript:void(0)"><i class="fa fa-user fa-fw" aria-hidden="true"></i>Profile</a>
          <a class="dropdown-item text-light" href="/logout"><i class="fa fa-sign-out fa-fw" aria-hidden="true"></i>signOut</a>
          @else
           <a class="dropdown-item text-light" href="/login"><i class="fa fa-sign-in fa-fw" aria-hidden="true"></i>Login</a>
           <a class="dropdown-item text-light" href="/register"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i>Register</a>
          @endif
        </div>
      </li>
    </ul>
  </div>
</nav>
</div>
</div>
<div class="container-fluid" style="margin-top:55px;">
<!--Nav starts-->
<div class="row">
 <div class="col-sm-12">
 <ul class="nav justify-content-center">
    @foreach($categories as $category)
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-dark" href="javascript:void(0)" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          {{$category->name}}
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          @if(count($category->subCategories))
            @foreach($category->subCategories as $subcategory)
          <a class="dropdown-item" href="javascript:void(0)">{{$subcategory->name}}</a>
            @endforeach
          @endif
        </div>
      </li>
  @endforeach
  </ul>
 </div>
</div>
<div class="container-fluid">
  <p class="font-weight-bold text-success p-0 m-0">frankako@outlook.com</p>
  <div class="row">
    <div class="col-sm-12 mt-2">
<div class="nav justify-content-center">
  <form class="form-inline my-2 my-lg-0">
    <div class="input-group">
    <input class="form-control" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
          <a href="javascript:void(0)" class="btn btn-secondary"><i class="fa fa-spinner fa-spin"></i></a>
          </div>
    </div>
    </form>
</div>
</div>
</div>
</div>
<!--Nav ends-->
 @yield('content')
</div>
<script type="text/javascript" src="/js/script.js"></script>
@yield('checkouts')
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>
</body>
</html>