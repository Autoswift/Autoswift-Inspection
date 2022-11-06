@extends('layouts.header')
@section('title', 'Headers')
@section('content')
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small>Header</small>
            </h1>
            <ol class="breadcrumb">
				<li>
					<i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
				</li>
				<li>
					<i class="fa fa-fw fa-tasks"></i>Addition
				</li>   
				<li class="active">
					<i class="fa fa-edit"></i>Header
				</li>
			    <span style="float:right;"><a target="_blank" href="{{route('header.create')}}"><i class="fa fa-plus"></i> Add New Header</a></span>
            </ol>
         </div>
      </div>
      <section class="content container-fluid">
      @include('layouts.alert')
      </section>
      <div class="row">
         <div class="col-lg-12">
            <div class="table-responsive">
               <table class="table table-bordered table-hover table-striped">
                  <thead>
                     <tr class="header-titles">
                        <th>S.No.</th>
                        <th>Mobile No</th>
                        <th>Licence No</th>
                        <th>Validity</th>
                        <th>IIISLA No</th>
                        <th>Email-1</th>
                        <th>Email-2</th>
                        <th>Authorizer  Name</th>
                        <th>Authorizer Education</th>
                        <th>Authorizer Designation</th>
                        <th>Report Heading</th>
                        <th>Logo</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                      @foreach($header as $k => $val)
                       <tr>
                         <td style="text-align:center;">{{$k+1}}</td>
                         <td>{{$val->mobile_number}}</td>
                         <td>{{$val->licence_no}}</td>
                         <td>{{$val->expire}}</td>
                         <td>{{$val->iisla_no}}</td>
                         <td>{{$val->email1}}</td>
                         <td>{{$val->email2}}</td>
                         <td>{{$val->authorizer_name}}</td>
                         <td>{{$val->authorizer_education}}</td>
                         <td>{{$val->authorizer_designation }}</td>
                         <td>{{$val->report_heading}}</td>
                         <td><img src="{{asset('image')}}/{{$val->logo}}" width="100px" height="50px"></td>
                         <td style="text-align:center;">
                           <a target="_blank" href="{{ route('header.edit',$val->id)}}" title="Edit"><i class="fa fa-pencil"></i></a>
							@if($val->id > 1)
							<a href="" rel="{{$val->id}}" class="delete_header" title="Delete"><i class="fa fa-trash"></i></a>
							@endif
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
<div id="deleteModal" class="delete-modal modal fade" role="dialog">
	<div class="modal-dialog modal-sm">
				   <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-body text-center">
				<h4 class="modal-heading">Are You Sure ?</h4>
				<p>Do you really want to delete the header? This process cannot be undone.</p>
			</div>
			<div class="modal-footer">
			{!! Form::open(['method' => 'DELETE', 'action' => ['HeaderController@destroy',0],'id'=>'delete_form']) !!}
				<button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
				<button type="submit" class="btn btn-danger">Yes</button>
			{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script>
$(document).on('click','.delete_header',function(event){
	event.preventDefault();
	$('#delete_form').attr('action','{{route("header.index")}}/'+$(this).attr('rel'));
	$('#deleteModal').modal('show');
});
</script>
@endsection