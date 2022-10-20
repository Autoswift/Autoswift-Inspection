@extends('layouts.header')
@section('title', 'Add Staff')
@section('content')
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small>Add Staff</small>
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
               <li class="active">
                  <i class="fa fa-edit"></i> Add Staff
               </li>
               <span style="float:right;"><a href="{{route('staff.index')}}"><i class="fa fa-arrow-left"></i> Back</a></span>
            </ol>
         </div>
      </div>
      <section class="content container-fluid">
       @include('layouts.alert')
       </section>
      {!!Form::open(['method' => 'POST', 'action' => 'StaffController@store','files' => true]) !!}      
      <div class="row">
         <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('name', 'Staff Name*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('name', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('name') }}</div>
               </div>
            </div>
         </div>
          <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
            {!! Form::label('mobile_number', 'Mobile Number*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('mobile_number', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('mobile_number') }}</div>
               </div>
            </div>
         </div>
          <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('address', 'Address*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('address', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('address') }}</div>
               </div>
            </div>
         </div>
          <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('staff_email', 'Email',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('staff_email', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('staff_email') }}</div>
               </div>
            </div>
         </div>
          <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('sort_name', 'Sort Name*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('sort_name', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('sort_name') }}</div>
               </div>
            </div>
         </div>
			<div class="col-lg-12"> 
				@include('User.user_documents_common')
			</div>
      
        <!-- <div class="input submit">
            <div class="submit"><input class="btn btn-default" style="width:100px;font-weight:bold;margin-left:195px" type="submit" ></div>
         </div> -->
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