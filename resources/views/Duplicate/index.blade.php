@extends('layouts.header')
@section('title', 'Duplicate Reasons')
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
               <small>Duplicate Reasons</small>
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
               <li>
                <i class="fa fa-fw fa-tasks"></i>Addition
              </li>
               <li class="active">
                  <i class="fa fa-edit"></i>Duplicate Reasons
               </li>
               <span style="float:right;"><a href="{{ route('duplicate.create')}}"><i class="fa fa-plus"></i> Add Duplicate Reason</a></span>
            </ol>
         </div>
      </div>
      <section class="content container-fluid">
      @include('layouts.alert')
      </section>
      <div class="row">
         <div class="col-lg-12">
            <div class="table-responsive">
               <table class="table table-bordered table-hover table-striped" style="width: 99.9%">
                  <thead>
                     <tr class="header-titles">
                        <th style="width:26px">S.No.</th>
                        <th>Duplicate Reasons</th>
                        <th style="display:none;">id</th>
                        <th style="text-align:left;">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                      @foreach($duplicate as $key=>$val)
                       <tr>
                         <td>{{$key+1}}</td>
                         <td style="display:none;">{{$val->id}}</td>
                         <td>{{$val->reason}}</td>
                         <td style="text-align:left;">
                           <a href="{{ route('duplicate.edit',$val->id)}}" title="Edit"><i class="fa fa-pencil"></i></a>
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
                            {!! Form::open(['method' => 'DELETE', 'action' => ['DuplicateController@destroy', $val->id]]) !!}
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
</div>
@endsection
@section('script')
<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js">
</script>
<script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
   }); 
 var table=$('table').DataTable({
    rowReorder: true,
    pageLength: 50,
    lengthMenu: [[50,100,500,1000], [50,100,500,1000]],
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
        $.post("{{route('duplicate_position')}}",filterdata,function(responce){
            console.log(responce);
        })
        $('#result').html( 'Event result:<br>'+result );
    } );
 }); 
</script>
@endsection