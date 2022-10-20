@extends('layouts.header')
@section('title', 'Valuations')
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
               <small>Valuations Initiated By</small>
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="/"> Dashboard</a>                            
               </li>
              <li>
                <i class="fa fa-fw fa-tasks"></i>Addition
              </li>
               <li class="active">
                  <i class="fa fa-edit"></i>Valuations Initiated By
               </li>
               <span style="float:right;"><a href="{{ route('valuation.create')}}"><i class="fa fa-plus"></i> Add Valuation Initiated By</a></span>
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
                        <th style="width:25px;">S.No.</th>
                        <th style="display:none;">id</th>
                        <th>Valuations Initiated By</th>
                        <th>Initials</th>
                        <th>Address</th>
                       	<th>VIB_Grid</th>
						<th>Status</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                      @foreach($valuation as $key => $val)
                       <tr>
                         <td>{{$key+1}}</td>
                         <td style="display:none;">{{$val->id}}</td>
                         <td>{{$val->name}}</td>
                         <td>{{$val->short_name}}</td>
                         <td>{{$val->address}}</td>
                         <td>
                         @if($val->grid_pdf!='' || $val->grid_pdf!=null)
                         	@foreach(json_decode($val->grid_pdf) as $k=>$pdf_path)
                         		<a href="{{asset('com_pdf').'/'.$pdf_path}}" target="_blank" style="font-weight: bold;text-decoration:none;" data-toggle="modal" class="grid-info-pdf" ><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                         	@endforeach
                         @else
                         	{{'N/A'}}
                         @endif
                         </td>
						<td>@if($val->status=='active')
                           <button type="button" class="btn btn-success btn-xs" onclick="statuschange('{{$val->id}}','{{$val->status}}')">Active</button>
                           @endif
                           @if($val->status=='inactive')
                           <button type="button" class="btn btn-warning btn-xs"  onclick="statuschange('{{$val->id}}','{{$val->status}}')">Inactive</button>
                           @endif
                        </td>
                         <td style="text-align:left;">
                           <a href="{{ route('valuation.edit',$val->id)}}" title="Edit"><i class="fa fa-pencil"></i></a>
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
                            {!! Form::open(['method' => 'DELETE', 'action' => ['ValuationController@destroy', $val->id]]) !!}
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
	<div class="modal fade text-left" id="grid-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel130" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
         <div class="modal-content">
            <div class="modal-body">
               <div id="myCarousel" class="carousel slide" data-ride="carousel">
                  <!-- Indicators -->
                  <ol class="carousel-indicators">
                     <li data-target="#myCarousel" data-slide-to="0"></li>
                     <li data-target="#myCarousel" data-slide-to="1"></li>
                     <li data-target="#myCarousel" data-slide-to="2"></li>
                  </ol>
                  <!-- Wrapper for slides -->
                  <div class="carousel-inner">
                  </div>
                  <!-- Left and right controls -->
                  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                  <span class="glyphicon glyphicon-chevron-left"></span>
                  <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control" href="#myCarousel" data-slide="next">
                  <span class="glyphicon glyphicon-chevron-right"></span>
                  <span class="sr-only">Next</span>
                  </a>
               </div>
            </div>
         </div>
      </div>
      <!-- /.container-fluid -->
   </div>
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
        $.post("{{route('valuation_position')}}",filterdata,function(responce){
           
        })
        $('#result').html( 'Event result:<br>'+result );
    });
 }); 
 
</script>
@endsection