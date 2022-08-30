@extends('layouts.header')
@section('title', 'Edit Received Notification')
@section('content')
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small>Edit Received Notification</small>
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
               <li class="active">
                  <i class="fa fa-edit"></i> Edit Received Notification
               </li>
               <span style="float:right;"><a href="{{route('company_notification.index')}}"><i class="fa fa-arrow-left"></i> Back</a></span>
            </ol>
         </div>
      </div>
      <section class="content container-fluid">
       @include('layouts.alert')
       </section>
      {!! Form::model($notification, ['method' => 'PATCH', 'action' => ['CompanyNotificationController@update', $notification->id]]) !!}    
      <div class="row">
        
         <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('registration_no', 'Registration Number',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('registration_no', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('registration_no') }}</div>
               </div>
            </div>
         </div>
         <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('make_model', 'Make Model',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('make_model', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('make_model') }}</div>
               </div>
            </div>
         </div>
         <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('party_name', 'Party Name',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('party_name', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('party_name') }}</div>
               </div>
            </div>
         </div> 
           <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('mobile_no', 'Mobile Number',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('mobile_no', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('mobile_no') }}</div>
               </div>
            </div>
         </div> 
          <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('place', 'Place',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('place', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('place') }}</div>
               </div>
            </div>
         </div>  
         <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('payment', 'Payment',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('payment', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('payment') }}</div>
               </div>
            </div>
         </div> 
         <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('file', 'File Url',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::url('file', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('file') }}</div>
               </div>
            </div>
         </div> 
         <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('note', 'Note',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::textarea('note', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('note') }}</div>
               </div>
            </div>
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