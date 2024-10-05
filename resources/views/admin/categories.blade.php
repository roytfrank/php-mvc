@extends('admin.layout')
@section('title', 'Admin Categories')
@section('active-page', 'adminCategories')
@section('content')
  <div class="card">
    <div class="card-body forms-card">
      <div class="row">
<!---start search form-->
      <div class="col-sm-6">
      <form action="" method="">
        <div class="form-group">
          <label for="categorysearch" class="font-weight-bold">Search</label>
           <div class="input-group">
          <input type="text" class="form-control" name="search" id="categorysearch" placeholder="Enter Search">
          <input type="hidden"class="form-control" name="token" value="{{\App\Classes\CSRFToken::token()}}">
          <div class="input-group-append">
            <button type="submit" class="btn btn-primary" name="searchButton" id="searchButton">Search</button>
          </div>
        </div>
        </div>
      </form>
    </div>
<!--end search form-->
<!---start add category form-->
      <div class="col-sm-6">
        <form action="/admin/categories" method="post">
        <div class="form-group">
          <label for="categoryname" class="font-weight-bold">Category Name</label>
          <div class="input-group">
          <input type="text" class="form-control" name="name" id="categoryname">
          <input type="hidden"class="form-control" name="token" value="{!!\App\Classes\CSRFToken::token()!!}" placeholder="Enter Category Name">
          <div class="input-group-append">
            <button type="submit" class="btn btn-primary" name="searchButton" id="searchButton" value="Search">Add</button>
            </div>
          </div>
        </div>
      </form>
    </div>
<!---start add category form-->
    </div>
 @if(isset($errors))
    @include('inc.errors')
  @endif
  </div>
<!---start categories table-->
      <div class="card-body table-card">
       <h5 class="text-secondary">CATEGORIES</h5>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Name</th>
                <th>Created</th>
                <th>Updated</th>
                <th>SubCategory+</th>
                <th>Action<br /><small>Edit & Delete</small></th>
              </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
              <tr>
                <td>{{$category['name']}}</td>
                <td>{{$category['created_at']}}</td>
                <td>{{$category['updated_at']}}</td>
                <td>

                <a href="" class="text-primary"  id="createSubCategory-{{$category['id']}}" data-toggle="modal" data-target="#addSubcategory-{{$category['id']}}" data-backdrop="static" data-keyboard="false"><i class="fa fa-plus" aria-hidden="true"></i></a>
<!--Add Sub Category Modal starts-->
<div class="modal fade mt-5" id="addSubcategory-{{$category['id']}}" tabindex="-1" role="dialog" aria-labelledby="addSubcategory-{{$category['id']}}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5 class="modal-title">Add SubCategory</h5>
        <button type="button" onclick="location.reload()" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <!--success notification start-->
  <div class="subnotification"></div>
<!--success notification ends-->
      <div class="modal-body">
        <form>
        <div class="form-group">
          <label for="categoryname" class="font-weight-bold">SubCategory Name</label>
          <div class="input-group">
          <input type="text" class="form-control" name="name" id="subname-{{$category['id']}}">
          <div class="input-group-append">
            <input type="submit" data-subtoken="{{\App\Classes\CSRFToken::token()}}" class="btn btn-primary addsubCategory" data-subid="{{$category['id']}}" value="Submit">
            </div>
          </div>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>
<!--Modal ends-->
                </td>
                <td>
                  <a href="" class="text-warning" id="editCategory-{{$category['id']}}" data-toggle="modal" data-target="#update-{{$category['id']}}" data-backdrop="static" data-keyboard="false"><i class="fa fa-edit fa-fw" aria-hidden="true"></i></a>&nbsp;&nbsp;
<!-- Modal start-->
<div class="modal fade mt-5" id="update-{{$category['id']}}" tabindex="-1" role="dialog" aria-labelledby="update-{{$category['id']}}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5 class="modal-title">Update Category</h5>
        <button type="button" onclick="location.reload()" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <!--success notification start-->
  <div class="updatenotification"></div>
<!--success notification ends-->
      <div class="modal-body">
        <form>
        <div class="form-group">
          <label for="categoryname" class="font-weight-bold">Category Name</label>
          <div class="input-group">
          <input type="text" class="form-control" name="name" id="name-{{$category['id']}}">
          <div class="input-group-append">
            <input type="submit" data-token="{{\App\Classes\CSRFToken::token()}}" class="btn btn-primary updateCategory" id="{{$category['id']}}" value="Update">
            </div>
          </div>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>
<!--Modal ends-->
  <a href="javascript:void(0)" class="text-danger" id="deleteCategory-{{$category['id']}}" data-toggle="modal" data-target="#delete-{{$category['id']}}" data-backdrop="static" data-keyboard="false"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></a>
<!-- Modal start-->
<div class="modal fade mt-5" id="delete-{{$category['id']}}" tabindex="-1" role="dialog" aria-labelledby="delete-{{$category['id']}}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5 class="modal-title">Delete Category</h5>
        <button type="button" onclick="location.reload()" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <!--success notification start-->
  <div class="deletenotification"></div>
<!--success notification ends-->
      <div class="modal-body">
      <p>Are you sure you want to delete this category</p>
        <form id="delete-deleteForm">
        <input type="submit" data-deltoken="{{\App\Classes\CSRFToken::token()}}" class="btn btn-danger deleteCategory" data-id="{{$category['id']}}" value="Yes Delete">
        <button type="button" onclick="location.reload()" class="btn btn-secondary float-right" data-dismiss="modal">Cancel</button>
       </form>
      </div>
    </div>
  </div>
</div>
<!--Modal ends-->
                </td>
              </tr>
             @endforeach
            </tbody>
          </table>
           {!! $links !!}
        </div>
      </div>
<!--categories table ends-->
<!---start subcategories table-->
      <div class="card-body table-card">
       <h5 class="text-secondary">SUBCATEGORIES</h5>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Name</th>
                <th>Created</th>
                <th>Updated</th>
                <th>Category</th>
                <th>Action<br /><small>Edit & Delete</small></th>
              </tr>
            </thead>
            <tbody>
            @foreach($subCategories as $subCategory)
              <tr>
                <td>{{$subCategory['name']}}</td>
                <td>{{$subCategory['created_at']}}</td>
                <td>{{$subCategory['updated_at']}}</td>
                <td>{{$subCategory['category_name']}}</td>
                <td>
                  <a href="" class="text-warning" id="toeditsubCategory-{{$subCategory['id']}}" data-target="#editsubCategory-{{$subCategory['id']}}" data-toggle="modal" data-backdrop="static" data-keyboard="false"><i class="fa fa-edit fa-fw"></i></a>&nbsp;&nbsp;

<!--Edit Sub Category Modal starts-->
<div class="modal fade mt-5" id="editsubCategory-{{$subCategory['id']}}" tabindex="-1" role="dialog" aria-labelledby="editsubCategory-{{$subCategory['id']}}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5 class="modal-title">Update SubCategory</h5>
        <button type="button" onclick="location.reload()" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <!--success notification start-->
  <div class="editsubnotification"></div>
<!--success notification ends-->
      <div class="modal-body">
        <form>
        <div class="form-group">
          <label class="font-weight-bold" for="subcategory-category-{{$subCategory['category_id']}}">Select Category</label>
          <select class="form-control" id="subcategory-category-{{$subCategory['id']}}">
            @foreach(\App\Models\Category::all() as $category)
            @if($category->id === $subCategory['category_id'])
            <option value="{{$category->id}}" selected>{{$category->name}}</option>
            @endif
            <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="categoryname" class="font-weight-bold">Enter New SubCategory</label>
          <input type="text" class="form-control" name="name" id="newsubname-{{$subCategory['id']}}" placeholder="{{$subCategory['name']}}">
        </div>
        <div class="form-group">
         <a href="javascript:void(0)" type="submit" data-editsubtoken="{{\App\Classes\CSRFToken::token()}}" class="btn btn-primary editsubCategory" data-editsubid="{{$subCategory['id']}}">Update</a>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>
<!--Modal ends-->
<a href="javascript:void(0)" class="text-danger" id="deletesubCategory-{{$subCategory['id']}}" data-toggle="modal" data-target="#deleteSubCategory-{{$subCategory['id']}}" data-backdrop="static" data-keyboard="false"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></a>
<!--Delete SubCategory Modal start-->
<div class="modal fade mt-5" id="deleteSubCategory-{{$subCategory['id']}}" tabindex="-1" role="dialog" aria-labelledby="deleteSubCategory-{{$subCategory['id']}}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5 class="modal-title">Delete SubCategory</h5>
        <button type="button" onclick="location.reload()" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <!--success notification start-->
  <div class="deletesubnotification"></div>
<!--success notification ends-->
      <div class="modal-body">
      <p>Are you sure you want to delete this subcategory</p>
        <form id="delete-deleteForm">
        <input type="submit" data-delsubtoken="{{\App\Classes\CSRFToken::token()}}" class="btn btn-danger deletesubCategory" data-delsubid="{{$subCategory['id']}}" value="Yes Delete">
        <button type="button" class="btn btn-secondary float-right" onclick="location.reload()" data-dismiss="modal">Cancel</button>
       </form>
      </div>
    </div>
  </div>
</div>
<!--Modal ends-->
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
          {!! $subCategories_links !!}
        </div>
      </div>
<!--subcategories table ends-->
    </div>
@endsection
