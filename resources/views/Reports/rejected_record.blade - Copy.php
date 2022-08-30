@extends('layouts.header')
@section('title', 'Home')
@section('content')

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
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small>Rejected Reports</small> 
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
               <li class="active">
                  <i class="fa fa-fw fa-ban"> </i>Rejected Reports
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
                        <th style="width:20px;">Inspection Date</th>
                        <th style="width:40px;">Reference No</th>
                        <th style="width:35px;">Application No</th>
                        <th style="width:20px;">Submited By</th>
                        <th style="width:35px;">Valuation Initiated By</th>
                        <th style="width:40px;">Financer Representative</th>
                        <th style="width:30px;">Registration No.</th>
                        <th style="width:35px;">Make & Model</th>
                        <th style="width:35px;">Finance Taken By</th>
                        <th style="width:40px;">Place of Valuation</th>
                        <th style="width:20px;">Total Amount</th>
                        <th style="width:20px;">Received Amount</th>
                        <th style="width:20px;">Rejected By</th>
                        <th style="text-align:center;width:20px;">Reject Reason</th>
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
     
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
</div>
@if($errors->any())
   <script type="text/javascript">
      toastr.error('{!! implode('', $errors->all('<div>:message</div>')) !!}',"Error");
   </script>
@endif
<script type="text/javascript">
  getdata()
function getdata(){
    $('#report_table').DataTable( {
         "processing": true,
         "serverSide": true,
         "ajax": {
                 url:"{{ route('reject_reports') }}",
                 type:"GET",
                 },
         "aoColumns": [
                     {data: 'DT_RowIndex', name: 'id'},
                     { data: 'inspection_date'},
                     { data: 'reference_no'},
                     { data: 'application_no'},
                     { data: 'submit_by'},
                     { data: 'name','searchable': 'false'},
                     { data: 'financer_representative'},
                     { data: 'registration_no'},
                     { data: 'make_model'},
                     { data: 'financed_by'},
                     { data: 'place_of_valuation'},
                     { data: 'total_amount'},
                     { data: 'amount_paid'},
                     { data: 'rejected_by'},
                     { data: 'reject_reason'},
                 ],
                 lengthMenu: [
                [ 100,500,1000],
                 [ '100','500','1000']
             ]      
                   
     }); 
}  
</script>


@endsection