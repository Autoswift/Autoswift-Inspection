@extends('Admin.layout')
@section('scriptcss')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="{{asset('admin_js_css/css/table-style.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('admin_js_css/css/basictable.css')}}" />
<style type="text/css">
   #table-no-resize_length{
   float: left;
   }
   #table-no-resize_filter{
   float:right;
   }
   select{
   padding: 0rem 0rem;
   }
   #table-no-resize_info{
   float: left;
   }
   #table-no-resize_paginate{
   float: right;
   }
   .profile_details{
   width: 30.25%;
   float: right;
   }
   ul.dropdown-menu.drp-mnu i.fa{
   margin-top: -6px;
   }   
   table.dataTable tbody td {
      text-align: center;
   }
   table.dataTable th {
      text-align: center;
   }
</style>
@endsection
@section('content') 
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="{{route('mobile_home')}}">Home</a><i class="fa fa-angle-right"></i>Notification</li>
   <button type="button" class="btn-primary" style="float: right;margin-right: 50px;" data-toggle="modal" data-target="#myModal">New Notification</button>
</ol>
<div class="agile-grids">
   <div class="agile-tables">
      <div class="w3l-table-info">
         <table id="table-no-resize" class="myTable">
            <thead>
               <tr>
                  <th>Sr No</th>
                  <th>Date</th>
                  <th>Executive Name</th>
                  <th>Registration No</th>
                  <th>Make & Model</th>
                  <th>Party Name</th>
                  <th>Mobile No</th>
                  <th>Place</th>
                  <th>Payment</th>
               </tr>
            </thead>
            <tbody>
               @foreach($notification as $key=>$value)
               <tr>
                  <td>{{$key+1}}</td>
                  <td>{{date('d-m-Y',strtotime($value->created_at))}}</td>
                  <td>{{$value->user->name}}</td>
                  <td>{{$value->registration_no}}</td>
                  <td>{{$value->make_model}}</td>
                  <td>{{$value->party_name}}</td>
                  <td>{{$value->mobile_no}}</td>
                  <td>{{$value->place}}</td>
                  <td>{{$value->payment}}</td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
</div>
<div id="myModal" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Send New Notification</h4>
         </div>
         <div class="modal-body">
            <form id="notification_form" method="post" action="{{route('send_notification')}}">
               @csrf
               <div class="vali-form">
                  <div class="col-md-12 form-group2 group-mail">
                     <label class="control-label">Mobile Executive</label>
                     <select name="user_id" id="user_id" required="">
                        <option value="">Select Executive</option>
                        @foreach($mobile_executive as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="col-md-12 form-group2 group-mail"></div>
                  <div class="clearfix"> </div>
                  <div class="col-md-6 form-group1 form-last ">
                     <label class="control-label">Registration Number</label>
                     <input type="text" placeholder="Registration Number" name="registration_no" id="registration_no" required="">
                  </div>
                  <div class="col-md-6 form-group1 form-last">
                     <label class="control-label">Make Model</label>
                     <input type="text" placeholder="Make Model" name="make_model" id="make_model" required="">
                  </div>
                  <div class="col-md-12 form-group2 group-mail"></div>
                  <div class="clearfix"> </div>
                  <div class="col-md-6 form-group1">
                     <label class="control-label">Party Name</label>
                     <input type="text" placeholder="Party Name" name="party_name" id="party_name" required="">
                  </div>
                  <div class="col-md-6 form-group1 form-last">
                     <label class="control-label">Mobile Number</label>
                     <input type="text" placeholder="Mobile Number" name="mobile_no" id="mobile_no" required="">
                  </div>
                  <div class="col-md-12 form-group2 group-mail"></div>
                  <div class="clearfix"> </div>
                  <div class="col-md-6 form-group1">
                     <label class="control-label">Place</label>
                     <input type="text" placeholder="Place" name="place" id="place" required="">
                  </div>
                  <div class="col-md-6 form-group1 form-last">
                     <label class="control-label">Payment</label>
                     <input type="text" placeholder="Payment" name="payment" id="payment" required="">
                  </div>
                  <div class="col-md-12 form-group2 group-mail"></div>
                  <div class="clearfix"> </div>
               </div>
               <div class="clearfix"> </div>
               <div class="col-md-12 form-group">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-default">Reset</button>
               </div>
               <div class="clearfix"> </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection
@section('script')
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
   $('.myTable').DataTable();
</script>
@endsection