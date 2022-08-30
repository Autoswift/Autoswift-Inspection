  @if (Session::has('added'))
  <div class="alert alert-success">
    <strong><i class="fa fa-check-circle"></i>&nbsp;&nbsp;</strong>{{session('added')}}
  </div>
  @elseif (Session::has('updated'))
  <div class="alert alert-info">
    <strong><i class="fa fa-check-circle"></i>&nbsp;&nbsp;</strong>{{session('updated')}}
  </div>
  @elseif (Session::has('deleted'))
  <div class="alert alert-danger">
    <strong><i class="fa fa-check-circle"></i>&nbsp;&nbsp;</strong>{{session('deleted')}}
  </div>
  @elseif (Session::has('error'))
  <div class="alert alert-danger">
    <strong><i class="fa fa-times-circle"></i>&nbsp;&nbsp;</strong>{{session('error')}}
  </div>
  @elseif (Session::has('warning'))
  <div class="alert alert-warning">
    <strong><i class="fa fa-check-circle"></i>&nbsp;&nbsp;</strong>{{session('warning')}}
  </div>
  @endif
 