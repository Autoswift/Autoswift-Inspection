@extends('layouts.header')
@section('title')
@php 
$urlroot=\Request::route()->getName();
@endphp
@if($urlroot=='report.index')
{{ __('Generate Bill') }}
@endif
@if($urlroot=='today_report')
{{ __("Today's Reports") }}
@endif
@if($urlroot=='duplicate_report')
{{ __('Duplicate Reports') }}
@endif
@if($urlroot=='mobile_report')
{{ __('Mobile Reports') }}
@endif
@if($urlroot=='old_reports')
{{ __('Old Reports') }}
@endif
@endsection
@section('style')
<style type="text/css">
	 ::placeholder {
	   color: rgb(85 85 85) !important;
	   opacity: 1; /* Firefox */
	   font-size:14px!important;
   }
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
   .fa-mobile{
		font-size: 18px;
   }
	table{
		font-weight: bold;
		border-collapse: inherit !important;
	}
		
	/*th {
		    text-align: center !important;
    padding: 20px !important;
	}
	table {
		border-collapse: inherit !important;
	}
	th, td {
	  border: 1px solid black !important;
	}*/
</style>
@endsection
@section('content')
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small id="page-header">@if($urlroot=='report.index')
			   {{ __('Generate Bill') }}
			   @endif
			   @if($urlroot=='today_report')
			   {{ __("Today's Reports") }}
			   @endif
			   @if($urlroot=='duplicate_report')
			   {{ __('Duplicate Reports') }}
			   @endif
			   @if($urlroot=='mobile_report')
			   {{ __('Mobile Reports') }}
			   @endif
			   @if($urlroot=='old_reports')
			   {{ __('Old Reports') }}
			   @endif
			   </small> 
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
               <li class="active">
                  <i class="fa fa-edit"></i><script type="text/javascript">
                     document.write(document.getElementById("page-header").innerText);
                  </script>
               </li>
               <span style="float:right;"><a href="{{route('report.create')}}"><i class="fa fa-plus"></i> Add New Report</a></span>
            </ol>
         </div>
      </div>
      <div class="row" style="margin:20px 0;">
         <div>
            <div style="border: 1px solid rgb(204, 204, 204); padding: 15px 0 0 0;">
               <form id="FinanceOldForm" action="@if($urlroot=='report.index') {{route('make_excel')}} @else {{route('report_excel')}} @endif" method="post" >
                  @csrf
                  <div style="display:none;"><input type="hidden" name="_method" value="POST"></div>
                  <div class="form-group" style="overflow: hidden;">
                     <div class="col-md-2">
                        <div class="input select">
                           {!!Form::select('valuation_by',$valuatation, null, ['class' => 'form-control','placeholder'=>'Search Valuation Initiated', 'id'=>'FinanceValuatationBy'])!!}
                        </div>
                     </div>
                     <div class="col-md-2">
                        <div class="input text"><input name="financer_representative" class="form-control" placeholder="Search Financer Representative" maxlength="255" type="text" id="financer_representative"></div>
                     </div>
                     <div class="col-md-2">
                        <div class="input text"><input type="text" name="make_model" class="form-control" placeholder="Search Make & Model" maxlength="255" type="text" id="make_model"></div>
                     </div>
                     <div class="col-md-2">
                        <div class="input text"><input name="registration_no" class="form-control" placeholder="Search Registration No" type="text" id="registration_no"></div>
                     </div>
                     <div class="col-md-2">
                        <div class="input text"><input name="reference_no" class="form-control" placeholder="Search Reference No." maxlength="255" type="text" id="reference_no"></div>
                     </div>
                     <div class="col-md-2">
                        <div class="input text"><input name="financed_by" class="form-control" placeholder="Search Finance Taken By" type="text" id="financed_by"></div>
                     </div>
                     <br>
                     <br>
                     <div class="col-md-2">
                        <div class="input text"><input type="text" name="s_date" class="form-control datepicker" id="to" placeholder="Search Bill Date From" value="{{old('s_date')}}" type="text"></div>
                     </div>
                     <div class="col-md-2">
                        <div class="input text"><input type="text" name="e_date" class="form-control datepicker" id="from" placeholder="Search Bill Date To" value="{{old('e_date')}}" type="text"></div>
                     </div>
                     <div class="col-md-2">
                        <div class="input text"><input type="text" name="create_date" class="form-control datepicker" id="createTo" placeholder="Search Creation Date From" value="{{old('create_date')}}" type="text"></div>
                     </div>
                     <div class="col-md-2">
                        <div class="input text"><input type="text" name="create_end" class="form-control datepicker" id="createFrom" placeholder="Search Creation Date To" value="{{old('create_end')}}" type="text"></div>
                     </div>
                     <div class="col-md-2">
                        <div class="input text"><input name="amount_from" class="form-control" placeholder="Amount From" type="text" id="FinanceAmountFrom"></div>
                     </div>
                     <div class="col-md-2">
                        <div class="input text"><input name="amount_to" class="form-control" placeholder="Amount To" type="text" id="FinanceAmountTo"></div>
                     </div>
                     <br>
                     <br>                
                     <div class="col-md-2">
                        <div class="input text"><input name="staff_name" class="form-control" placeholder="Search Staff Name" maxlength="255" type="text" id="FinanceStaffName"></div>
                     </div>
                     <div class="col-md-2">
                        <div class="input text"><input name="application_no" class="form-control" placeholder="Search Application No" maxlength="255" type="text" id="application_no"></div>
                     </div>
                      <div class="col-md-2">
                        <div class="input text"><input name="chachees_number" class="form-control" placeholder="Search Chassis Number" maxlength="255" type="text" id="  chachees_number"></div>
                     </div>
                     @if(Auth()->user()->role==1)
                     <div class="col-md-2">
                        <div class="input select">
                           {!!Form::select('user_id',$user, null, ['class' => 'form-control','placeholder'=>'Search User', 'id'=>'user_id'])!!}
                        </div>
                     </div>
                     @endif
                     <div class="col-md-2">
                        <div class="input select">
                           <select name="search_on" class="form-control" id="search_on">
                              <option value="0">Complete</option>
                              <option value="5">Incomplete</option>
                              <option value="1">Payment Pending</option>
                              <option value="2">Payment Received</option>
                              <option value="3">Deposit</option>
                              <option value="4">Non-Deposit</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-1">
                        <div class="input submit">
                           <button type="button" class="btn btn-default" id="search" style="font-weight:bold;"> Search</button>
                        </div>
                     </div>
                     @if($urlroot=='report.index')
                      <div class="col-md-1">
                        <div class="input submit">
                            <button type="submit" class="btn btn-default"style="font-weight:bold;">Bill</button>
                        </div>
                      </div>
                      @endif
                     @if($urlroot=='today_report')
                       <div class="col-md-1">
                        <div class="input submit">
							<button name="today_report" value="<?php echo date('d-m-Y'); ?>" type="submit" class="btn btn-default"style="font-weight:bold;">Excel</button>
                        </div>
                      </div>
                     @endif
					
                     @if($urlroot=='old_reports')
                      <div class="col-md-1">
                        <div class="input submit">
                            <button name="old_reports" value="1" type="submit" class="btn btn-default"style="font-weight:bold;">Excel</button>
                        </div>
                      </div>
                      @endif
					
                     @if($urlroot=='mobile_report')
                      <div class="col-md-1">
                        <div class="input submit">
                            <button name="mobile_data" value="1" type="submit" class="btn btn-default"style="font-weight:bold;">Excel</button>
                        </div>
                      </div>
                      @endif
					
                     @if($urlroot=='duplicate_report')
                      <div class="col-md-1">
                        <div class="input submit">
                            <button name="duplicate_entry" value="1" type="submit" class="btn btn-default"style="font-weight:bold;">Excel</button>
                        </div>
                      </div>
                      @endif
                      
                     <!-- <div class="col-md-1">
                        </div> -->
                  </div>
               </form>
            </div>
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
                        <th style="text-align:center;width:6px;" >S.No.</th>
						<th style="width:17px;">Creation Date</th>
                        <th style="width:14px;">Report Date</th>
                        <th style="width:24px;">Inspection Date</th>
                        <th style="width:25px;">Reference No</th>
                        <th style="width:27px;">Application No</th>
                        <th style="width:10px;">Staff</th>
                        <th style="width:20px;">Created By</th>
                        <th style="width:35px;">Valuation Initiated By</th>
                        <th style="width:40px;">Financer Representative</th>
                        <th style="width:30px;">Registration No.</th>
                        <th style="width:25px;">Make & Model</th>
                        <th style="width:25px;">Finance Taken By</th>
                        <th style="width:25px;">Place of Valuation</th>
                        <th style="width:20px;">Total Amount</th>
                        <th style="width:20px;">Received Amount</th>
                        <th style="width:25px;">Remaining Amount</th>
                        <th style="text-align:center;width:15px;">Action</th>
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
                   {!! Form::open(['method' => 'DELETE', 'action' => ['FinanceController@destroy',0],'id'=>'delete_form']) !!}
                       <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                       <button type="submit" class="btn btn-danger">Yes</button>
                   {!! Form::close() !!}
                 </div>
               </div>
         </div>
      </div>
      <div id="deposite_Modal" class="modal fade" role="dialog">
         <div class="modal-dialog">
            <!-- Modal content-->
            {!! Form::open(['method' => 'PUT', 'action' => ['FinanceController@update_deposit',0],'id'=>'deposit_form']) !!}
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Report Deposit</h4>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-lg-4">
                        <div class="form-group" style="overflow: hidden;">
                           {!! Form::label('Deposit Amount', 'Deposit Amount*',[]) !!}
                           {!! Form::text('amount', null, ['class' => 'form-control','required']) !!}
                        </div>
                     </div>
                     <div class="col-lg-4">
                        <div class="form-group" style="overflow: hidden;">
                           {!! Form::label("Depositor's Name and Date", "Depositor's Name&Date",[]) !!}
                           {!! Form::text('paid_person', null, ['class' => 'form-control','required']) !!}
                        </div>
                     </div>
                     <div class="col-lg-4">
                        <div class="form-group" style="overflow: hidden;">
                           {!! Form::label('Balance Amount', 'Balance Amount*') !!}
                           {!! Form::text('paid_date', null, ['class' => 'form-control']) !!}
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                  <button type="submit" class="btn btn-success">Yes</button>
               </div>
            </div>
            {!! Form::close() !!}
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
   $('input[type=text]').keyup(function () {
      this.value = this.value.toUpperCase();
   })
   page="{{\Request::route()->getName()}}"
   var filterdata={}
   if(page=='mobile_report'){
      filterdata = {mobile_data:1};    
   }else if(page=='today_report'){
      filterdata={today_report:"{{date('d-m-Y')}}"}
   }else if(page=='duplicate_report'){
      filterdata={duplicate_entry:1};
   }
   if(page!='report.index'){
         getdata();
   }
    $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
    });

$(document).keypress(function (e) {
	if (e.which == 13) {
    $('#search').trigger('click');
  }
});
	
   $('#search').click(function(){
      event.preventDefault();
      $('#report_table').DataTable().destroy();
        var formdata = $("#FinanceOldForm").serializeArray();
        $(formdata).each(function(index, obj){
            filterdata[obj.name] = obj.value;
        });
        filterdata['search'] = true;
      getdata()
   })
   $(document).on('click','.delete_report',function(){
      event.preventDefault();
      $('#delete_form').attr('action','{{route("report.index")}}/'+$(this).attr('id'))
      $('#deleteModal').modal('show');
   })
    $(document).on('click','.deposite_amount',function(){
      user="{{Auth()->user()->role}}";
      if(user!=1){
         toastr.error("This action is unauthorized");
         return false;
      }
      event.preventDefault();
      $.get('{{route("update_deposit")}}/'+$(this).attr('id'),function(result){
         $('input[name=amount]').val(result.amount)
         $('input[name=paid_date]').val(result.paid_date)
         $('input[name=paid_person]').val(result.paid_person)
      })
      $('#deposit_form').attr('action','{{route("update_deposit")}}/'+$(this).attr('id'))
      $('#deposite_Modal').modal('show');
   })
   $('#deposit_form').submit(function(){
      event.preventDefault();
      $.post($('#deposit_form').attr('action'),$('#deposit_form').serialize(),function(result){
          if(result.status==true){
              toastr.success(result.msg,"Success");
          } else{
              toastr.error("Somthing Went Wrong","Error");
          }
          $('#deposite_Modal').modal('hide');
       });
   }) 
function getdata(){
    $('#report_table').DataTable( {
         "processing": true,
         "serverSide": true,
         "ajax": {
                 url:"{{ route('report.index') }}",
                 type:"GET",
                 data:{filterdata:filterdata},
                 },
         "aoColumns": [
                     {data: 'DT_RowIndex', name: 'id'},
			 		 { data: 'created' },
                     { data: 'report_date' },
                     { data: 'inspection_date'},
                     { data: 'reference_no'},
                     { data: 'application_no'},
                     { data: 'staff_name'},
                     { data: 'created_by',"searchable": false},
                     { data: 'name','searchable': 'false'},
                     { data: 'financer_representative'},
                     { data: 'registration_no'},
                     { data: 'make_model'},
                     { data: 'financed_by'},
                     { data: 'place_of_valuation'},
                     { data: 'total_amount'},
                     { data: 'amount_paid'},
                     { data: 'remaining_amount'},
                     { data: 'action',"searchable": false},
                 ],
                 "columnDefs": [
					  	  { "width": "6px", "targets": 0 },
                          { "width": "17px", "targets": 1 },
                          { "width": "14px", "targets": 2 },
                          { "width": "24px", "targets": 3 },
                          { "width": "25px", "targets": 4 },
                          { "width": "27px", "targets": 5 },
                          { "width": "10px", "targets": 6 },
                          { "width": "20px", "targets": 7 },
                          { "width": "35px", "targets": 8 },
                          { "width": "40px", "targets": 9 },
                          { "width": "30px", "targets": 10 },
                          { "width": "25px", "targets": 11 },
                          { "width": "25px", "targets": 12 },
                          { "width": "25px", "targets": 13 },
                          { "width": "20px", "targets": 14 },
                          { "width": "20px", "targets": 15 },
                          { "width": "25px", "targets": 16 },
                          { "width": "15px", "targets": 17 },
                   {
					   
                        "targets": 0,
                        "render": function(data, type, row, meta){
                            mb=''
                            if(row['mobile_data']=='1'){
                                mb='<i class="fa fa-mobile"></i>';
                              }
                               return mb+"&nbsp;"+data+'<br><input type="checkbox" name="reportid" value="'+row['id']+'">';
                        }
                    }
                ],
                 "rowCallback": function( row, data, index ) {
                 if(data.remaining_amount > 0)
                 {
                     $('td', row).css('background-color', '#f2dede');
                 }
                 if(data.amount >0){
                     $('td', row).css('background-color', '#76fb86');
                 }
                  if(data.fair_amount==0){
                     $('td', row).css('background-color', '#f1f779');
                  } 
                  if(data.duplicate_entry == "1"){
                     $(row).find('td:eq(4)').css('background-color', 'red');
                     $(row).find('td:eq(10)').css('background-color', 'red');
                  }
                  if(data.mobile_data == 1){
                     $(row).find('td:eq(0)').css('background-color', '#acbce2');
                  }
                  }, lengthMenu: [
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
      $.post('{{route("multiple_delete")}}',{report:checks},function(res){
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