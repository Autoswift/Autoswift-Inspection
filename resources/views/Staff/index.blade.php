@extends('layouts.header')
@section('title', 'All Staff')
@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css">
@endsection
@section('content')
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small>Staff</small>
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
               <li class="active">
                  <i class="fa fa-edit"></i>Staff
               </li>
               <span style="float:right;"><a href="{{ route('staff.create')}}"><i class="fa fa-plus"></i> Add Staff </a></span>
            </ol>
         </div>
      </div>
      <section class="content container-fluid">
      @include('layouts.alert')
      </section>
      <div class="row">
         <div class="col-lg-12">
            <div class="table-responsive">
               <table class="table table-bordered table-hover table-striped" style="width: 100%">
                  <thead>
                     <tr>
                        <th>S.No.</th>
                        <th>ID</th>
                        <th>Staff Name</th>
                        <th>Sort Name</th>
                        <th>Mobile No</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Docs</th>
                        <th>Creation Date</th>
                        <th>Status</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                      @foreach($staff as $key=>$val)
                       <tr>
                         <td>{{$key+1}}</td>
                          <td>{{$val->id}}</td>
                         <td>{{$val->name}}</td>
                         <td>{{$val->sort_name}}</td>
                         <td>{{$val->mobile_number}}</td>
                         <td>{{$val->address}}</td>
                         <td>{{$val->staff_email}}</td>
                         <td>@if ($val->icard != null OR $val->govt_issue_id != null OR $val->back_govt_card != null)<a data-url="{{$val->icard}},{{$val->govt_issue_id}},{{$val->back_govt_card}}"><i class="fa fa-picture-o open_photo_slider" aria-hidden="true"></i></a> @else N/A @endif</td>
                         <td><?php echo date('d-m-Y', strtotime($val->created_at))?></td>
                         <td>
                           <button type="button" class="btn @if($val->status)btn-success @else btn-warning @endif staff_status" id="{{$val->id}}">@if($val->status) Active @else Inactive @endif</button>     
                          </td>
                         <td>
                           <a href="{{ route('staff.edit',$val->id)}}" title="Edit"><i class="fa fa-pencil"></i></a>
                           <a href="" data-toggle="modal" data-target="#{{$val->id}}deleteModal" title="Delete"><i class="fa fa-trash"></i></a>
                           <div id="{{$val->id}}deleteModal" class="delete-modal modal fade" role="dialog">
                      <div class="modal-dialog modal-sm">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-body text-center">
                            <h4 class="modal-heading">Are You Sure ?</h4>
                            <p>Do you really want to delete these records? This process cannot be undone.</p>
                          </div>
                          <div class="modal-footer">
                            {!! Form::open(['method' => 'DELETE', 'action' => ['StaffController@destroy', $val->id]]) !!}
                                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                                <button type="submit" class="btn btn-danger">Yes</button>
                            {!! Form::close() !!}
                          </div>
                        </div>
                      </div>
                    </div>
                        </td>
                     </tr>
                  @endforeach   
                  </tbody>
               </table>
            </div>
           
         </div>
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
@include('layouts.custom_image_slider')
</div>
@endsection
@section('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js">
</script>
<script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>
<script type="text/javascript">
  var table=$('table').DataTable({
  	 rowReorder: true,
    pageLength: 50,
    lengthMenu: [[50,100,500,1000], [50,100,500,1000]],
  });
   $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
  table.on( 'row-reorder', function ( e, diff, edit ) {
        var filterdata={}
        var result = 'Reorder started on row: '+edit.triggerRow.data()[1]+'<br>';
        for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
            var rowData = table.row( diff[i].node ).data();
            result += rowData[1]+' updated to be in position '+
                diff[i].newData+' (was '+diff[i].oldData+')<br>';
                filterdata[rowData[1]] =  diff[i].newData;
        }
        //console.log(filterdata)
        $.post("{{route('staff_position')}}",filterdata,function(responce){
            console.log(responce);
        })
        $('#result').html( 'Event result:<br>'+result );
    } );   
  $(document).on('click','.staff_status',function(){
  	id=$(this).attr('id')
  	swal({
           title: "Are you sure?",
           text: "You Want Change Status !",
           icon: "warning",
           buttons: true,
           dangerMode: true,
         })
         .then((willDelete) => {
         if (willDelete) {
           $.post("{{route('staff_status')}}",{id:id},function(result){
               if(result.status==true){
                 toastr.success(result.msg,"Success");
                 setTimeout(function(){ location.reload(); }, 500);
                 } else{
                 toastr.error(result.msg,"Error");
               }
           })
         }
       }); 
  })
</script>
@endsection