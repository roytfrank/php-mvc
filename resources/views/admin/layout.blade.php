<!DOCTYPE html>
    <html lang="en">
        <head>
           <meta charset="utf-8">
               <title>REJOY @yield('title')</title>
           <meta name="viewport" content="width=device-width, initial-scale = 1.0">
           <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="stylesheet" type="text/css" href="/css/style.css">
    <script src="https://use.fontawesome.com/9bc7c468ee.js"></script>
</head>
<body class="layout-body" data-template-id="@yield('active-page')">

<div class="container-fluid bg-dark fixed-top" id="navbar-section">
	 <div class="container">
			<nav class="navbar navbar-expand-md navbar-dark bg-dark">
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
     <span class="navbar-toggler-icon"></span>
  </button>
<a class="navbar-brand text-primary font-weight-bold" href="/">REJOY</a>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto" id="#adminNav">
     <li class="nav-item mt-2">
        <a class="nav-link disabled d-none d-md-inline" href="javascript:void(0)" tabindex="-1" aria-disabled="true">&#9997</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link text-danger" href="/logout">SignOut<i class="fa fa-sign-out fa-fw" aria-hidden="true"></i></a>
      </li>
    </ul>
  </div>
</nav>
</div>
</div>

<div class="container-fluid" style="margin-top:56px;">
  <div class="row">
    <div class="col-sm-2" id="sidenavimage">
      <nav class="nav flex-column" id="admin-sidenavbar">
      <a class="nav-link active" href="/admin/dashboard"><i class="fa fa-tachometer fa-fw"></i>Dashboard</a>
      <a class="nav-link" href="/admin/products"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>Add Product</a>
      <a class="nav-link" href="/admin/products/rejoy"><i class="fa fa-product-hunt fa-fw" aria-hidden="true"></i>Manage Product</a>
      <a class="nav-link" href="/admin/categories"><i class="fa fa-align-justify fa-fw" aria-hidden="true"></i>Categories</a>
       <a class="nav-link" href="/rejoy/users"><i class="fa fa-users fa-fw" aria-hidden="true"></i>Rejoy Users</a>
        <a class="nav-link" href="/rejoy/payments"><i class="fa fa-credit-card fa-fw" aria-hidden="true"></i>Payments</a>
       <a class="nav-link" href="/rejoy/orders"><i class="fa fa-first-order fa-fw" aria-hidden="true"></i>Orders</a>
    </nav>
</div>
  <div class="col-sm-10" id="admin-content">
    @yield('content')
  </div>
</div>
</div>

<script type="text/javascript" src="/js/script.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>
</body>
</html>

