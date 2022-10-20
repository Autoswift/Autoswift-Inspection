@extends('layouts.header')
@section('title', 'Edit '.$role)
@section('content')
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small>Edit {{$role}}</small>
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
               <li class="active">
                  <i class="fa fa-edit"></i>Edit {{$role}}
               </li>
               <span style="float:right;"><a href="{{route('users.index')}}/{{$role_list_page}}"><i class="fa fa-arrow-left"></i> Back</a></span>
            </ol>
         </div>
      </div>
      <section class="content container-fluid">
       @include('layouts.alert')
       </section>
      {!! Form::model($users, ['method' => 'PATCH', 'action' => ['UserController@update', $users->id],'files'=>true, 'id' =>'userEditForm']) !!}       
      <div class="row">
         <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('role', 'Position*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::select('role',$roles,null,['class' => 'form-control col-md-6','id'=>'role', 'readonly'=>'readonly']) !!}
                  <div class="error-message"> {{ $errors->first('role') }}</div>
               </div>
            </div>
            <div class="form-group mobileadmin" style="overflow: hidden;">
               {!! Form::label('comp_id', 'Valuation Initiated by*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::select('comp_id',$company,null,['class' => 'form-control col-md-6','placeholder'=>'Select Valuation Initiated by']) !!}
                  <div class="error-message"> {{ $errors->first('comp_id') }}</div>
               </div>
            </div>
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('state', 'State*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::select('state',$state,null,['class' => 'form-control col-md-6','id'=>'state']) !!}
                  <div class="error-message"> {{ $errors->first('state') }}</div>
               </div>
            </div>
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('area_id', 'Area/City*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::select('area_id',$areas,null,['class' => 'form-control col-md-6','id'=>'area']) !!}
                  <div class="error-message"> {{ $errors->first('area_id') }}</div>
               </div>
            </div>
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('name', 'Name*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('name', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('name') }}</div>
               </div>
            </div>
             <div class="form-group" style="overflow: hidden;">
               {!! Form::label('username', 'Username*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('username', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('username') }}</div>
               </div>
            </div>
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('pass1', 'Password*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('pass1', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('pass1') }}</div>
               </div>
            </div>
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('mobile_number', 'Mobile Number*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('mobile_number', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('mobile_number') }}</div>
               </div>
            </div>
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('address', 'Address',['class' => 'col-md-2']) !!}
				<div class="col-md-6">
					@if($users['role'] == 4)
						{!! Form::text('address', null, ['class' => 'form-control col-md-6', 'disabled' => 'disabled']) !!}
					@else
						{!! Form::text('address', null, ['class' => 'form-control col-md-6']) !!}
					@endif
					<div class="error-message"> {{ $errors->first('address') }}</div>
				</div>
            </div>
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('email', 'Email',['class' => 'col-md-2']) !!}
				<div class="col-md-6">
					@if($users['role'] == 4)
						{!! Form::text('email', null, ['class' => 'form-control col-md-6', 'disabled' => 'disabled']) !!}
					@else
						{!! Form::text('email', null, ['class' => 'form-control col-md-6']) !!}
					@endif
					<div class="error-message"> {{ $errors->first('email') }}</div>
				</div>
            </div>
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('employee_id', 'Reference Number*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('employee_id', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('employee_id') }}</div>
               </div>
            </div>
			@if($users['role'] == 4)
            <div class="form-group" style="overflow: hidden;">
				{!! Form::label('device_id', 'Device Id',['class' => 'col-md-2']) !!}
				<div class="col-md-6">
					{!! Form::text('device_id', null, ['class' => 'form-control col-md-6', 'disabled' => 'disabled']) !!}
					<div class="error-message"> {{ $errors->first('device_id') }}</div>
				</div>
            </div>
			@endif
			@if($users['role'] == 4)
				@include('User.user_documents_common', ['noedit' => true])
			@else
				@include('User.user_documents_common')
			@endif
         </div>
        <!-- <div class="input submit">
            <div class="submit"><input class="btn btn-default" style="width:100px;font-weight:bold;margin-left:195px" type="submit" ></div>
         </div>-->
			<div class="input submit">
				<div class="col-md-offset-2 col-md-6 submit" style="padding: 0 0 0 24px;">
					<input class="btn btn-success" type="submit" value="Submit">
					@if($users['role'] == 4)
						<span class="pull-right reset_kyc_wrapper"><input class="btn btn-danger resetButton" type="submit" value="Reset Mobile KYC"></span>
					@endif
				</div>
			</div>
      </div>
       {!! Form::close() !!}
   </div>
   <!-- /.row -->
</div>
<!-- /.container-fluid -->
</div>
@endsection
<script type="text/javascript" src="https://www.arvindampro.in/app-assets/js/scripts/sweetalert.min.js"></script>
@section('script')
<script type="text/javascript">
	$('#reset_kyc_alert').remove();
    $('.resetButton').on('click',function(event){
		event.preventDefault()
		swal({
			title: "Are you sure",
			text: 'Do you want the reset the Employee KYC?',
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willReset) => {
			if (willReset) {
				$('.reset_kyc_wrapper').append('<input id="reset_kyc_alert" type="hidden" name="reset_kyc" value="yes">');
				$('#userEditForm').submit();
			}
		})
	});
	
    $('#role').on('change',function(){
        role=$('#role').val();
        if(role==1){
            //$('.webadmin').hide();
            $('.mobileadmin').hide();
            $('input[name="address"]').closest('.form-group').show();
            $('input[name="employee_id"]').closest('.form-group').show();
        }else if(role==2){
            $('.webadmin').show();
            $('.mobileadmin').hide();
            $('input[name="address"]').closest('.form-group').show();
            $('input[name="employee_id"]').closest('.form-group').show();
        }else if(role==4){
            //$('.webadmin').hide();
            $('.mobileadmin').show();
            //$('input[name="address"]').closest('.form-group').hide();
            $('input[name="employee_id"]').closest('.form-group').show();
        }else if(role==5){
            $('.webadmin').hide();
            $('.mobileadmin').show();
            $('input[name="address"]').closest('.form-group').show();
            $('input[name="employee_id"]').closest('.form-group').hide();
        }
    })
   $('#state').on('change',function(){
         state=$('#state').val();
         $.ajax({
            url:"{{ url('getstatearea') }}",
            type:'GET',
            data: {state:state},
            success:function($result){
               $('#area').empty();
               $.each($result,function(key,value){
                  $('#area').append($("<option></option>").attr("value",value).text(key)); 
               })
            }
         })
   })
   $('#role').trigger('change');
</script>
@endsection