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
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link d-none d-md-block text-light" href="/cart">Cart&nbsp;<i class="fa fa-cart-plus"></i></a>
      </li>
      <strong class="d-none d-md-inline mt-2 text-dark">|</strong>
      <li class="nav-item dropdown">
        <a class="nav-link text-white" href="javascript:void(0)" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Member
        </a>
        <div class="dropdown-menu rounded-0 bg-secondary" aria-labelledby="navbarDropdow" id="memberdropdown">
          <a class="dropdown-item text-light" href="/login"><i class="fa fa-sign-in fa-fw" aria-hidden="true"></i>Login</a>
          <a class="dropdown-item text-light" href="/register"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i>Register</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
</div>
</div>
<div class="container-fluid" style="margin-top:110px;">
 @yield('content')
</div>
<script type="text/javascript" src="/js/script.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>
<div class="container-fluid">
@yield('footer')
</div>
</body>
</html>