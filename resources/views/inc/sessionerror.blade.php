<div class="alert alert-danger alert-dismissible fade show" role="alert">
         <strong>Alert&nbsp;</strong>{{$_SESSION['error']}}
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
     <span aria-hidden="true">&times;</span>
     </button>
     <?php unset($_SESSION['error']);?>
</div>