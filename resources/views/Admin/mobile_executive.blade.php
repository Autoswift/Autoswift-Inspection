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
	table {
  table-layout:fixed;
}
table td {
  word-wrap: break-word;
  max-width: 400px;
}
table td {
  white-space:inherit;
}
	.dt-buttons{
		margin-bottom: 8px;
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
   <li class="breadcrumb-item"><a href="{{route('mobile_home')}}">Home</a><i class="fa fa-angle-right"></i>Mobile Executive</li>
</ol>
<div class="agile-grids">
<!-- tables -->
<div class="agile-tables">
   <div class="w3l-table-info">
    <div style="float: right;margin-right: 22px;">
    <label>Status </label>
    <select id="user_status">
      <option value="">All</option>
      <option value="active">Active</option>
      <option value="inactive">InActive</option>
      <option value="pending">Pending</option>
      <option value="requested">Requested</option>
    </select>
  </div>
      <table id="table-no-resize" class="myTable">
         <thead>
            <tr>
               <th style="width:28px;">#</th>
               <th>State-City</th>
               <th>Mobile Executive</th>
               <th>Refernce No.</th>
               <th>UserName</th>
               <th>Password</th>
               <th>Mobile No.</th>
               <th>Email Id</th>
               <th>Status</th>
            </tr>
         </thead>
         <tbody>
            @foreach($user as $key => $value)
            </tr>
            <td>{{$key+1}}</td>
            <td>{{$value->area_id?$value->area->name:'N/A'}}</td>
            <td>{{$value->name}}</td>
            <td>{{$value->employee_id}}</td>
            <td>{{$value->username}}</td>
            <td>{{$value->pass1}}</td>
            <td>{{$value->mobile_number}}</td>
            <td>{{$value->email}}</td>
            <td>{{ucfirst($value->status)}}</td>
            </tr>
            @endforeach
         </tbody>
      </table>
   </div>
   <!-- //tables -->
</div>
@endsection
@section('script')
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript">
   $(document).ready( function () {
	    header='Mobile Executive';
      var table =$('.myTable').DataTable({
            pageLength: 50,
            lengthMenu: [[50,100,500,1000], [50,100,500,1000]],
			 dom: 'Blfrtip',
			 buttons: [
             {
                 extend: 'excel',
                 title: header,
             },
         ],
         });
      $('#user_status').change( function() {
        if($(this).val()){
           table.column(8)
           .search("^" + $(this).val() + "$", true, false, true)
           .draw();
        }else{
          table.search( '' ).columns().search( '' ).draw();
        }
      });
   } );
</script>
@endsection