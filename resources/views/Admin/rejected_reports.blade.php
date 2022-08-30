@extends('Admin.layout')
@section('title', 'Autoswift')
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
                <li class="breadcrumb-item"><a href="{{route('mobile_home')}}">Home</a><i class="fa fa-angle-right"></i><span id="report_st">Rejected Reports</span></li>
            </ol>
<div class="agile-grids">	
				<!-- tables -->
				
				<div class="agile-tables">
					<div class="w3l-table-info">
				  <table id="table-no-resize" class="myTable">
					<thead>
					  <tr>
						<th>S.No</th>
						<th>Report Date</th> 
						<th>Inspection Date</th>
						<th>Executive Name</th>
						<th>Registration No</th>
						<th>Application No</th>
						<th>Rejected Date</th>
						<th>Rejected Reason</th>
						<th>From Pdf</th>
						<th>Zip Photos</th>
					  </tr>
					</thead>
					<tbody>
					  
					</tbody>
				  </table>
				</div>
				<!-- //tables -->
			</div>
@endsection
@section('script')
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.myTable').DataTable( {
        "processing": true,
        "serverSide": true,
        "pageLength": 50,
      	"lengthMenu": [[50,100,500,1000], [50,100,500,1000]],
        "ajax": {
                url:"{{route('rejected_reports')}}",
                type:"GET",
                },
        "aoColumns": [
                    { data: 'DT_RowIndex' },
					{ data: 'report_date' },
                    { data: 'inspection_date' },
                    { data: 'name'},
                    { data: 'registration_no'},
                    { data: 'application_no'},
                    { data: 'updated_at'},
                    { data: 'reject_reason'},
					{ data: 'form_pdf'}
                ],"columnDefs": [
                   {
                        "targets":8,
                        orderable: false,
                        "render": function(data, type, row, meta){
                         if(row['form_pdf']!=null){
                        		 return st='<a href="../uploads/finance/form_pdf/'+row['form_pdf']+'" target="_blank">'+status.charAt(0).toUpperCase() + status.slice(1)+'</a>';
                        	}
                     	  return '';
                        }
                    },
                    {
                        "targets":9,
                        orderable: false,
                        "render": function(data, type, row, meta){
                            return '<a href="javascript:generatezip('+row['id']+')">Zip Photo</a>';
                        }
                    }
                ]
    } );
 });   
function generatezip(id){
   window.location.href = "{{route('make_zip')}}/"+id;
}  
</script> 
@endsection			