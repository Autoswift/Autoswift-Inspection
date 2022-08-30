@extends('layouts.header')
@php $role=Request::segment(2);
$item_id=Request::segment(2);
if(\Request::route()->getName()=='userfill'){
$item_id=Request::segment(3);
}
@endphp
@section('title')
@if($role=='web_admin')
{{ __('Web Admins (P)') }}
@elseif($role=='mobile_admin')
{{ __('Mobile-Company Admins (P-A)') }}
@elseif($role=='mobile_executive')
{{ __('Mobile Executives (A)') }}
@elseif($role=='company_user')
{{ __('Company Executives (P)') }}
@else
{{ __('Total Employees') }}
@endif
@endsection
@section('style')
<style type="text/css">
	 div .dt-button{
			background-color: #5f7cb7;
			color: #fff;
			border: none;
			border-radius: 10px;
		  }
	.buttons-columnVisibility .active{
		color: red;
	}
	table{
		width: "100%; !important";
	}
	.swal-text {
		font-size: 18px;
		font-weight: bolder;
	}
	/* button.swal-button.swal-button--cancel{
		    background-color: red;
	}*/
	button.swal-button.swal-button--defeat{
		    background-color: red;
	}
	button.swal-button.swal-button--defeat:hover{
		    background-color: red;
	}
	button.swal-button.swal-button--catch{
		    background-color: green;
	}
	button.swal-button.swal-button--catch:hover{
		    background-color: green;
	}
	table{
      margin: 0 auto;
      width: 100%;
      clear: both;
      border-collapse: collapse;
      table-layout: fixed; 
      word-wrap:break-word; 
    }
  	.dt-buttons {
    	/*position: relative;*/
    	float: right !important;
    	top: -6px;
    	left: -5px;
  	}
  	.dt-buttons .dt-button.buttons-excel, .dt-buttons .dt-button.buttons-collection, .dt-button-collection .dt-button.active{
      background-color: #31708F !important;
    }
  	div.dt-button-collection button.dt-button:active:not(.disabled), div.dt-button-collection button.dt-button.active:not(.disabled){
      background: #31708F !important;
    }
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
@endsection
@section('content')
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small id="page-header">
               @if($role=='web_admin')
               {{ __('Web Admins (P)') }}
               @elseif($role=='mobile_admin')
               {{ __('Company Admins (P)') }}
               @elseif($role=='mobile_executive')
               {{ __('Mobile Executives (A)') }}
               @elseif($role=='company_user')
               {{ __('Company Executives (P)') }}
               @else
               {{ __('Total Employees') }}
               @endif
               </small>
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
               <li>
                  <i class="fa fa-fw fa-users"></i>Employees
               </li>
               <li class="active">
                  <i class="fa fa-edit"></i> <script type="text/javascript">
                     document.write(document.getElementById("page-header").innerText);
                  </script>
               </li>
               <span style="float:right;"><a href="{{ route('users.create')}}"><i class="fa fa-plus"></i> Add User</a></span>
            </ol>
         </div>
      </div>
      <section class="content container-fluid">
         @include('layouts.alert')
      </section>
      <div class="row">
		<div class="col-lg-12" style="margin: 0 0 15px 5px;">
        	{!! Form::Label('Status', 'Status:') !!}
         	{!! Form::select('item_id',['all'=>'All','active'=>'Active','inactive'=>'Inactive','pending'=>'Pending','requested'=>'Requested'],$item_id, ['id' => 'fillter']) !!}
		</div>
         <div class="col-lg-12">
            <div class="table-responsive">
               <table class="table table-bordered table-hover table-striped" style="width: 99.9%">
                  <thead>
                     <tr class="header-titles">
                        <th style="text-align:left;" width="40px">S.No.</th>
                        <th>ID</th>
                        @if($role=='mobile_admin'||$role=='mobile_executive'||$role=='company_user')
                        <th>Company Name</th>
                       	<th>State</th>
                        <th>City</th>
                        @endif
                        @if(!$role)
                        <th>Position</th>
                        @endif
                        <th>@if($role=='web_admin')
                           {{ __('Web Admin Name') }}
                           @endif
                           @if($role=='mobile_admin')
                           {{ __('Mobile Admin Name') }}
                           @endif
                           @if($role=='mobile_executive')
                           {{ __('Mobile Executive Name') }}
                           @endif
                           @if($role=='company_user')
                           {{ __('Company Executive Name') }}
                           @endif
                           @if($role!='web_admin' && $role!='mobile_admin' && $role!='mobile_executive' && $role!='company_user')
                           {{ __('Employee Name') }}
                           @endif
                        </th>
                        @if($role!='company_user' && $role!='mobile_admin')   
                        <th>Reference Number</th>
                        @endif
                        <th>User Name</th>
                        <th>Password</th>
                        <th>Mobile No</th>
                        <th>Photo</th>
                        <th>Address</th>
                        <th>Email</th> 
                       	@if($role!='mobile_executive')
                        <th>Creation Date</th>
                       	@endif
                        @if($role=='mobile_executive')
                        <th>App Version</th>
                        <th>Mobile Model</th>
                        <th>Track</th>
                       	<th>Creation Date</th>
                        @endif
                        @if($role=='mobile_executive')
                        <th>Device Id</th>
                        @endif
                        <th>Status</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @php
                     $i=0;
                     @endphp
                     @foreach($users as $val)
                     @php
                     $i++;
                     @endphp
                     <tr>
                        <td style="text-align:left;"  width="20px">{{$i}}</td>
                       	<td>{{$val->id}}</td>
                        @if($role=='mobile_admin'||$role=='mobile_executive'||$role=='company_user')
                        <td>{{$val->valuation?$val->valuation->name:'N/A'}}</td>
                       	<td>{{($val->area_id && $val->state) ? $val->state->name:'N/A'}}</td>
                        <td>{{($val->area_id && $val->area) ? $val->area->name:'N/A'}}</td>
                        @endif
                        @if(!$role)
                        <td>
                           @if($val->role==1)
                           {{ __('Super Admin') }}
                           @endif
                           @if($val->role==2)
                           {{ __('Web Admin') }}
                           @endif
                           @if($val->role==3)
                           {{ __('Mobile Admin') }}
                           @endif
                           @if($val->role==4)
                           {{ __('Mobile Executive') }}
                           @endif
                           @if($val->role==5)
                           {{ __('Company User') }} 
                           @endif
                        </td>
                        @endif
                        <td>{{$val->name}}</td>
                        @if($role!='company_user' && $role!='mobile_admin')
                        <td>{{$val->employee_id}}:{{$val->ref_start}}&nbsp;&nbsp;<span class="action-edit" style="cursor:pointer" onclick=edit_ref({{$val->id}},{{$val->ref_start}}) id=edit{{$val->id}}><i class="fa fa-edit"></i></i></span><span id=refresh{{$val->id}}><span></td>
                        @endif
                        <td>{{$val->username}}</td>
                        <td>{{$val->pass1}}</td>
                        <td>{{$val->mobile_number}}</td>
						<td>
                           @if($val->icard!=''&& $val->icard!=null)
                           <a href="" data-toggle="modal" data-target="#info" title="photo" onclick="showphoto('{{$val->id}}')"><i class="fa fa-picture-o" aria-hidden="true"></i></a>
                           @else
                           {{'N/A'}}
                           @endif
                        </td>
                        <td>{{$val->address?$val->address:'N/A'}}</td>
                    	<td>{{$val->email?$val->email:'N/A'}}</td>
                    	@if($role!='mobile_executive')
                    	<td>{{date('d-m-Y',strtotime($val->created_at))}}</td>
                    	@endif
                        @if($role=='mobile_executive')
                        <td>{{$val->app_version?$val->app_version:'N/A'}}</td>
                        <td>{{$val->mobile_model?$val->mobile_model:'N/A'}}</td>
                        <td>@if($val->location)<a href="http://maps.google.com/maps?q=loc:{{$val->location}}"><i class="fa fa-map-marker" aria-hidden="true"></i></a>@else N/A @endif</td>
                    	<td>{{date('d-m-Y',strtotime($val->created_at))}}</td>
                        @endif
                        @if($role=='mobile_executive')
                        <td>{{$val->device_id?$val->device_id:'N/A'}}</td>
                        @endif
                        
                        <td>@if($val->status=='active')
                           <button type="button" class="btn btn-success btn-xs" onclick="statuschange('{{$val->id}}','{{$val->status}}')">Active</button>
                           @endif
                           @if($val->status=='inactive')
                           <button type="button" class="btn btn-warning btn-xs"  onclick="statuschange('{{$val->id}}','{{$val->status}}')">Inactive</button>
                           @endif
                           @if($val->status=='requested')
                           <button type="button" class="btn btn-info btn-xs"  onclick="statuschange('{{$val->id}}','{{$val->status}}')">Requested</button>
                           @endif
                           @if($val->status=='pending')
                           <button type="button" class="btn btn-danger btn-xs"  onclick="statuschange('{{$val->id}}','{{$val->status}}')">Pending</button>
                           @endif
                        </td>
                        <td style="text-align:center;">
                           <a href="{{ route('users.edit',$val->id)}}" title="Edit"><i class="fa fa-pencil"></i></a>
                           <a href="" data-toggle="modal" data-target="#{{$val->id}}deleteModal" title="Delete"><i class="fa fa-trash"></i></a>
                           @if($role=='mobile_admin' || $role=='mobile_executive')
                           <a href="" data-toggle="modal" data-target="#{{$val->id}}showmore" title="More"><i class="fa fa-eye"></i></a>
                           @endif
                           @if($role=='mobile_executive')
                           <a href="{{route('user_notification.show',$val->id)}}" title="Send Notification"> <i class="fa fa-bell" aria-hidden="true"></i></a>
                           @endif
                           <div id="{{$val->id}}deleteModal" class="delete-modal modal fade" role="dialog">
                              <div class="modal-dialog modal-sm">
                                 <!-- Modal content-->
                                 <div class="modal-content">
                                    <div class="modal-body text-center">
                                       <h4 class="modal-heading">Are You Sure ?</h4>
                                       <p>Do you really want to delete these records? This process cannot be undone.</p>
                                    </div>
                                    <div class="modal-footer">
                                       {!! Form::open(['method' => 'DELETE', 'action' => ['UserController@destroy', $val->id]]) !!}
                                       <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                                       <button type="submit" class="btn btn-danger">Yes</button>
                                       {!! Form::close() !!}
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div id="{{$val->id}}showmore" class="delete-modal modal fade" role="dialog">
                              <div class="modal-dialog modal-lg">
                                 <!-- Modal content-->
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <button type="button" class="close" data-dismiss="modal">&times;</button>
                                       <h4 class="modal-title">More Detail</h4>
                                    </div>
                                    <div class="modal-body text-center">
                                       <table class="table table-bordered table-striped" >
                                          <tr>
                                             <th style="text-align: center;">App Version</th>
                                             <th style="text-align: center;">Mobile Model</th>
                                             <th style="text-align: center;">Track</th>
                                             <th style="text-align: center;">Creation Date</th>
                                          </tr>
                                          <tr>
                                            <td>{{$val->app_version?$val->app_version:'N/A'}}</td>
                                             <td>{{$val->mobile_model?$val->mobile_model:'N/A'}}</td>
                                             <td>@if($val->location)<a href="http://maps.google.com/maps?q=loc:{{$val->location}}"><i class="fa fa-map-marker" aria-hidden="true"></i></a>@else N/A @endif</td>
                                             <td>{{date('d-m-Y',strtotime($val->created_at))}}</td>
                                          </tr>
                                       </table>
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
   <div class="modal fade text-left" id="info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel130" aria-hidden="true">
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
@endsection
@section('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.colVis.min.js"></script>
<script type="text/javascript">
   header=$.trim($('#page-header').text());
	user="{{Auth()->user()->role}}";
   if('{{$role}}'=='mobile_admin'||'{{$role}}'=='mobile_executive'){
    $('.table-hover').DataTable({
      pageLength: 50,
      lengthMenu: [[50,100,500,1000], [50,100,500,1000]],
      dom: 'Blfrtip',
			 buttons: [
             {
                 extend: 'excel',
                 title: header,
                 exportOptions: {
                     columns: ':visible'
                 }
             },
             'colvis'
         ],
         columnDefs: [ {
             targets:[-5,-6,-7,-8,-9],
             visible: false
         } ]
    }).buttons()
      .container()
      .appendTo(".breadcrumb");
   }else{
    $('.table-hover').DataTable({
      pageLength: 50,
      lengthMenu: [[50,100,500,1000], [50,100,500,1000]],
      dom: 'Blfrtip',
         buttons: [
             {
                 extend: 'excel',
                 title: header,
                 exportOptions: {
                     columns: ':visible'
                 }
             },
             'colvis'
         ]
    }).buttons()
      .container()
      .appendTo(".breadcrumb");
   }
    route="{{\Request::route()->getName()}}"
    $('#fillter').change(function(){
       if(route!='userfill'){
          window.location.href = "{{route('users.index')}}"+'/'+$('#fillter').val();
       }else{
          window.location.href = "{{route('users.index')}}"+'/'+'{{Request::segment(2)}}/'+$('#fillter').val();   
       }
       
    })
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    }); 
    function edit_ref(id,start){
     $("#refresh"+id).html('<input type="number" name="ref_from" class="name_val" value='+start+'>');
     $("#edit"+id).html('<i class="fa fa-save" style=color:#28C76F></i>');
     $("#edit"+id).attr("onclick","refresh("+id+")");
    }
    function showphoto(id){
      $('.carousel-inner').empty();
       $.post("{{route('document')}}",{user_id:id},function(result){
           $('.carousel-inner').html('<div class="item active"><img src="{{asset("document")}}/'+result.icard+'" alt="Los Angeles" style="width:100%;"></div><div class="item"><img src="{{asset("document")}}/'+result.govt_issue_id+'" alt="Chicago" style="width:100%;"></div><div class="item"><img src="{{asset("document")}}/'+result.back_govt_card+'" alt="New york" style="width:100%;"></div>')
          $('#info').modal('show');
       });  
     } 
    function refresh(id){
    ref_start=$('#refresh'+id+' input.name_val').val();
    $.ajax({
           type:"POST",
           url:"{{route('changereferno')}}",
           data:{id:id,ref_start:ref_start},
           success: function(response){
             if(response.status==true){
                 toastr.success("Refernce No. "+response.msg,"Success");
              } else{
                 toastr.error(response.msg,"Error");
             }
           }
         });  
    }
	setTimeout(function(){
		$("div .dt-button").css({ "background-color" : "#5f7cb7",
			"color": "#fff",
			"border": "none",
			"border-radius":"10px"});
		$('.dataTables_length').css({ "padding" : "5px"});

	},2000);
	
/*	setTimeout(function(){
		$('button.dt-button.buttons-columnVisibility.active').css({ "background" : "none", "background-color" : "green", "color": "white", "border": "none" })
		
	},5000);	
	$('button').click(function(){
			alert("hi");
		})
	*/

	
    function statuschange(id,status){
      user="{{Auth()->user()->role}}";
      if(user!=1){
         toastr.error("This action is unauthorized");
         return false;
      }
	 if(status=='requested'){
		  toastr.info("You cannot change status");
		return false;
	  }
     if(status=='active'||status=='inactive'){
         swal({
           title: "Are you sure?",
           text: "You Want Change Status !",
           icon: "warning",
           buttons: true,
           dangerMode: true,
         })
         .then((willDelete) => {
         if (willDelete) {
           if(status=='active'){
             status='inactive';
           }else{
             status='active';
           }
           $.post("{{route('statuschange')}}",{id:id,status:status},function(result){
               if(result.status==true){
                 toastr.success(result.msg,"Success");
                 setTimeout(function(){ location.reload(); }, 500);
                 } else{
                 toastr.error(result.msg,"Error");
               }
           })
         }
         }); 
       }
     if(status=='pending'){
       swal("Please Choose Option", {
		   buttons: {
			 cancel: "Cancel",
			 catch: {
			   text: "Accept",
			   value: "catch",
			   ButtonColor: 'red',
			 },
			 defeat: {
			   text: "Reject",
			   value: "defeat",
			 },
		   },
		 })
		 .then((value) => {
			 if(value=='catch'){
			   status='active';
			 }
			 if(value=='defeat'){
			   status='requested';
			 }
			 $.post("{{route('statuschange')}}",{id:id,status:status},function(result){
					if(result.status==true){
					 toastr.success(result.msg,"Success");
					 setTimeout(function(){ location.reload(); }, 500);
					 } else{
					 toastr.error(result.msg,"Error");
				   }
			   })
		   });
     	} 
    }
	user="{{Auth()->user()->role}}";
      if(user!=1){
         $('.buttons-excel').hide();
      }
</script>
@endsection