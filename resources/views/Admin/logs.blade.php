@extends('layouts.header')
@section('title', "User Log's")
@section('content')
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small>User Log's</small>
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
                <li>
                  <i class="fa fa-bell"></i>Settings                        
               </li>
               <li class="active">
                  <i class="fa fa-edit"></i> User Log's
               </li>
               
            </ol>
         </div>
      </div>
      <section class="content container-fluid">
      @include('layouts.alert')
      </section>
      <div class="row">
         <div class="col-lg-12">
            <div class="table-responsive">
               <table class="table table-bordered table-hover table-striped">
                  <thead>
                     <tr>
                        <th style="text-align:center;">#</th>
                        <th>client_ip</th>
                        <th>User</th>
                        <th>Device</th>
                        <th>Os</th>
                        <th>Browser</th>
                        <th>Last Activty</th>
                     </tr>
                  </thead>
                  <tbody>
                     
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(function () {
   $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    
    var table = $('table').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        lengthMenu: [[50,100,500,1000], [50,100,500,1000]],
        ajax: "{{ route('logs') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'client_ip', name: 'client_ip'},
            {data: 'user.name', name: 'user.name'},
            {data: 'device.kind', name: 'device.kind '},
            {data: 'device.platform', name: 'device.platform'},           
            {data: 'agent.browser', name: 'agent.browser'},
            {data: 'updated_at', name: 'updated_at'},
        ]
    });
   }); 
</script>
@endsection