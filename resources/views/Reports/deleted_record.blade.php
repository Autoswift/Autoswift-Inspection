@extends('layouts.header')
@section('title', 'Recycle Bin')
@section('style')
<style type="text/css">
   th {
   font-size: 12px !important;
   text-align: center !important;
   }
   .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
   border-bottom-width: 2px !important;
   display: table-cell !important;
   }
   .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
   border: 1px solid #ddd !important;
   }
   .table>thead>tr>th {
   vertical-align: bottom !important;
   }
   .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
   padding: 8px !important;
   line-height: 1.42857143 !important;
   }
   tr {
   display: table-row !important;
   vertical-align: inherit !important;
   border-color: inherit !important;
   }
   tbody {
   display: table-row-group !important;
   vertical-align: middle !important;
   border-color: inherit !important;
   }
   .table-striped>tbody>tr:nth-of-type(odd) {
   background-color: #f9f9f9 !important;
   }
   tbody>tr{
   font-size: 12px !important;
   text-align: center !important;
   }
   .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
   border-bottom-width: 2px !important;
   }
   td{
   word-wrap:break-word !important;
   }
</style>
@endsection
@section('content')
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      @php 
      $urlroot=\Request::route()->getName();
      @endphp
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small> Recycle Bin</small> 
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
               <li>
                  <i class="fa fa-bell"></i>Settings                        
               </li>
               <li class="active">
                  <i class="fa fa-trash" aria-hidden="true"></i> &nbsp;Recycle Bin
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
               <table class="table table-bordered table-hover table-striped" id="report_table" style="width:100%;table-layout: fixed;background-color: transparent;border-spacing: 0;border-collapse: collapse;">
                  <thead>
                     <tr>
                        <th style="text-align:center;width:7px;" >S.No.</th>
                        <th style="width:15px;">Deletion Date</th>
                        <th style="width:15px;">Report Date</th>
                        <th style="width:20px;">Inspection Date</th>
                        <th style="width:40px;">Reference No</th>
                        <th style="width:35px;">Application No</th>
                        <th style="width:20px;">Staff</th>
                        <th style="width:35px;">Valuation Initiated By</th>
                        <th style="width:40px;">Financer Representative</th>
                        <th style="width:30px;">Registration No.</th>
                        <th style="width:35px;">Make & Model</th>
                        <th style="width:35px;">Finance Taken By</th>
                        <th style="width:40px;">Place of Valuation</th>
                        <th style="width:20px;">Total Amount</th>
                        <th style="width:20px;">Received Amount</th>
                        <th style="width:20px;">Remaining Amount</th>
                        <th style="text-align:center;width:20px;">Action</th>
                     </tr>
                  </thead>
                  <tbody>  
                  </tbody>
               </table>
            </div>
            <style>
               .pagination{
               float: right !important;
               margin-top: -5px !important;
               }
               } 
            </style>
         </div>
      </div>
      <div id="deleteModal" class="delete-modal modal fade" role="dialog">
         <div class="modal-dialog modal-sm">
                           <!-- Modal content-->
               <div class="modal-content">
                 <div class="modal-body text-center">
                   <h4 class="modal-heading">Are You Sure ?</h4>
                   <p>Do you really want to delete these records? This process cannot be undone.</p>
                 </div>
                 <div class="modal-footer">
                   {!! Form::open(['method' => 'POST', 'action' => ['FinanceController@report_delete',0],'id'=>'delete_form']) !!}
                       <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                       <button type="submit" class="btn btn-danger">Yes</button>
                   {!! Form::close() !!}
                 </div>
               </div>
         </div>
      </div>
      <div id="restoreModal" class="delete-modal modal fade" role="dialog">
         <div class="modal-dialog modal-sm">
                           <!-- Modal content-->
               <div class="modal-content">
                 <div class="modal-body text-center">
                   <h4 class="modal-heading">Are You Sure ?</h4>
                   <p>Do you really want to Restore these records.</p>
                 </div>
                 <div class="modal-footer">
                   {!! Form::open(['method' => 'POST', 'action' => ['FinanceController@report_restore',0],'id'=>'restore_form']) !!}
                       <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                       <button type="submit" class="btn btn-danger">Yes</button>
                   {!! Form::close() !!}
                 </div>
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
@if($errors->any())
   <script type="text/javascript">
      toastr.error('{!! implode('', $errors->all('<div>:message</div>')) !!}',"Error");
   </script>
@endif
<script type="text/javascript">
  getdata()
   $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
    }); 
   $(document).on('click','.delete_report',function(){
      event.preventDefault();
      $('#delete_form').attr('action','{{route("report_delete")}}/'+$(this).attr('id'))
      $('#deleteModal').modal('show');
   }) 
    $(document).on('click','.restore_report',function(){
      event.preventDefault();
      $('#restore_form').attr('action','{{route("report_restore")}}/'+$(this).attr('id'))
      $('#restoreModal').modal('show');
   }) 
function getdata(){
    $('#report_table').DataTable( {
         "processing": true,
         "serverSide": true,
         "ajax": {
                 url:"{{ route('deleted_report') }}",
                 type:"GET",
                 },
         "aoColumns": [
                     {data: 'DT_RowIndex', name: 'id'},
                     { data: 'updated_at',},
                     { data: 'report_date' },
                     { data: 'inspection_date'},
                     { data: 'reference_no'},
                     { data: 'application_no'},
                     { data: 'staff_name'},
                     { data: 'name','searchable': 'false'},
                     { data: 'financer_representative'},
                     { data: 'registration_no'},
                     { data: 'make_model'},
                     { data: 'financed_by'},
                     { data: 'place_of_valuation'},
                     { data: 'total_amount'},
                     { data: 'amount_paid'},
                     { data: 'remaining_amount'},
                     { data: 'action'},
                 ],
                 "columnDefs": [
                   {
                        "targets": 0,
                        "render": function(data, type, row, meta){
                          return "&nbsp;"+data+'<br><input type="checkbox" name="reportid" value="'+row['id']+'">';
                        }
                    }
                ], lengthMenu: [
                [ 100,500,1000],
                 [ '100','500','1000']
             ]      
                   
     });
     $('.dataTables_length').append('&nbsp;<button class="btn" id="delete_reports"><i class="fa fa-trash"></i></button>'); 
}
$(document).on('click','#delete_reports',function(){
   var checks = $('input[type="checkbox"]:checked').map(function() {
    return $(this).val();
  }).get()
  if (checks.length === 0) {
    toastr.error('Report not Selected','Error');
    return false;
  }
   if(confirm("Are you sure that you want to Delete Reports?")){
      $.post('{{route("multiple_delete_report")}}',{report:checks},function(res){
         if(res.status){
           toastr.success(res.msg,'Success');
           setTimeout(function(){
             location.reload();
           },600)
         }else{
           toastr.error('Somting Wrong','Error')
         }
      })
   }
})   
</script>


@endsection