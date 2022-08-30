

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
      <div class="row">
         <div class="col-lg-12">
            <div class="table-responsive">
               <table class="table table-bordered table-hover table-striped" id="report_table" style="width:100%;table-layout: fixed;background-color: transparent;border-spacing: 0;border-collapse: collapse;">
                  <thead>
                     <tr>
                        <th style="text-align:center;width:7px;" >S.No.</th>
                        <th style="width:15px;">Creation Date</th>
                        <th style="width:15px;">Report Date</th>
                        <th style="width:20px;">Inspection Date</th>
                        <th style="width:40px;">Reference No</th>
                        <th style="width:35px;">Application No</th>
                        <th style="width:20px;">Created By</th>
                        <th style="width:35px;">Valuation Initiated By</th>
                        <th style="width:40px;">Financer Representative</th>
                        <th style="width:30px;">Registration No.</th>
                        <th style="width:35px;">Make & Model</th>
                        <th style="width:35px;">Finance Taken By</th>
                        <th style="width:40px;">Place of Valuation</th>
                       <!--  <th style="width:20px;">Total Amount</th>
                        <th style="width:20px;">Received Amount</th>
                        <th style="width:20px;">Remaining Amount</th> -->
                         <th style="width:50px;">Duplicate Reason</th>
                     </tr>
                  </thead>
                  <tbody>
                  @foreach($report as $item)
                  <tr>
                    <td>{{$item->id}}</td>
                    <td>{{date('d-m-Y',strtotime($item->created_at))}}</td>
                    <td>{{date('d-m-Y',(int)$item->report_date)}}</td>
                    <td>{{$item->inspection_date}}</td>
                    <td>{{$item->reference_no}}</td>
                    <td>{{$item->application_no}}</td>
                    <td>{{$item->created_by}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->financer_representative}}</td>
                    <td>{{$item->registration_no}}</td>
                    <td>{{$item->make_model}}</td>
                    <td>{{$item->financed_by}}</td>
                    <td>{{$item->place_of_valuation}}</td>
                   <!--  <td>{{$item->total_amount}}</td>
                    <td>{{$item->amount_paid}}</td>
                    <td>{{$item->remaining_amount}}</td> -->
                    <td>{{$item->reason}}</td>
                  </tr>  
                  @endforeach  
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
   </div>
 </div>
 <script type="text/javascript">
   $('#report_table').DataTable({ "order": [[ 0, 'desc' ]]});
 </script>
