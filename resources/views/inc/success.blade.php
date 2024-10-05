<div class="alert alert-success alert-dismissible fade show" role="alert">
         <strong>Login&nbsp;</strong>{{$_SESSION['register']['success']}}
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
     <span aria-hidden="true">&times;</span>
     </button>
     <?php unset($_SESSION['register']['success']);?>
</div>