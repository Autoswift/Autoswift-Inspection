@extends('layouts.header')
@section('title', 'Add '.$role)
@section('content')
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small id="titleuser">Add {{$role}}</small>
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
               <li class="active">
                  <i class="fa fa-edit"></i> Add {{$role}}
               </li>
               <span style="float:right;"><a href="{{route('users.index')}}/{{$role_list_page}}"><i class="fa fa-arrow-left"></i> Back</a></span>
            </ol>
         </div>
      </div>
      <section class="content container-fluid">
       @include('layouts.alert')
       </section>
      {!!Form::open(['method' => 'POST', 'action' => 'UserController@store','files'=>true]) !!}      
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
                  {!! Form::select('state',$state,null,['class' => 'form-control col-md-6','id'=>'state','placeholder'=>"Select State"]) !!}
                  <div class="error-message"> {{ $errors->first('state') }}</div>
               </div>
            </div>
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('area_id', 'Area/City*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::select('area_id',array('Select State First'),null,['class' => 'form-control col-md-6','id'=>'area']) !!}
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
                  {!! Form::text('pass1', old('pass1'), ['class' => 'form-control col-md-6']) !!}
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
                  {!! Form::text('address', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('address') }}</div>
               </div>
            </div>
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('email', 'Email',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('email', null, ['class' => 'form-control col-md-6']) !!}
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
			@include('User.user_documents_common')
			</div>
		  <div class="input submit">
			  <div class="col-md-offset-2 col-md-6 submit" style="padding: 0 0 0 24px;">
				  <input class="btn btn-success" type="submit" value="Submit">
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
@section('script')
<script type="text/javascript">
    $('#role').on('change',function(){
        $('input[type="file"]').val(null)
        $('select[name="area_id"]').val(''); 
        role=$('#role').val();
        if(role==1){
            //$('.webadmin').hide();
            $('.mobileadmin').hide();
             $('input[name="email"]').closest('.form-group').show();
            $('input[name="address"]').closest('.form-group').show();
            $('input[name="employee_id"]').closest('.form-group').show();
        }else if(role==2){
            $('.webadmin').show();
            $('.mobileadmin').hide();
             $('input[name="email"]').closest('.form-group').show();
            $('input[name="address"]').closest('.form-group').show();
            $('input[name="employee_id"]').closest('.form-group').show();
        }else if(role==4){
            $('.webadmin').hide();
            $('.mobileadmin').show();
            $('input[name="email"]').closest('.form-group').hide();
            $('input[name="address"]').closest('.form-group').hide();
            $('input[name="employee_id"]').closest('.form-group').show();
        }else if(role==5){
            $('.mobileadmin').show();
            $('input[name="email"]').closest('.form-group').show();
            $('input[name="address"]').closest('.form-group').show();
            $('input[name="employee_id"]').closest('.form-group').hide();
        }
    });
   $('#state').on('change',function(){
         state=$('#state').val();
         $.ajax({
            url:"{{ url('getstatearea') }}",
            type:'GET',
            data: {state:state},
            success:function($result){
               $('#area').empty();
               $('#area').append($("<option></option>").attr("value",'').text('Select City/Area'));
               $.each($result,function(key,value){
                if("{{ old('area_id') }}" == value) {
					$('#area').append($("<option selected></option>").attr("value",value).text(key)); 
				} else {
					$('#area').append($("<option></option>").attr("value",value).text(key)); 
				}
               })
            }
         })
   })
   $('#state').trigger('change');
   $('#role').trigger('change');
</script>
@endsection