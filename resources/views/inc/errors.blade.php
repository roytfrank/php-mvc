<div class="alert alert-danger alert-dismissible fade show position-fixed" role="alert" style="z-index:10000;">
  @foreach($errors as $the_errors)
     @foreach($the_errors as $error)
         <strong>Error!&nbsp;</strong>{{$error}}<br />
     @endforeach
  @endforeach
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
     <span aria-hidden="true">&times;</span>
     </button>
</div>