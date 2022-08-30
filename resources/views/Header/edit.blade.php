@extends('layouts.header')
@section('title', 'Edit Headers')
@section('content')
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading --> 
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small>Edit Header</small>
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>
               </li>
               <li>
                  <i class="fa fa-fw fa-tasks"></i>Addition
               </li>
               <li class="active">
                  <i class="fa fa-edit"></i> Edit Header
               </li>
               <span style="float:right;"><a href="{{route('header.index')}}"><i class="fa fa-arrow-left"></i> Back</a></span>
            </ol>
         </div>
      </div>
      <section class="content container-fluid">
         @include('layouts.alert')
      </section>
      {!! Form::model($header, ['method' => 'PATCH', 'action' => ['HeaderController@update', $header->id],'files' => true]) !!}      
      <div class="row">
         <div class="col-lg-12">
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('licence_no', 'Licence No*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('licence_no', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('licence_no') }}</div>
               </div>
            </div>
            <div class="form-group" style="overflow: hidden;">
               {!! Form::select('ex_validity',array('validity' => 'Validity', 'iisla_no' => 'IIISLA No'),$header->expire?'validity':'iisla_no',['class' => 'form-control col-md-2','id'=>'ex_validity','style'=>'width:15%;margin-right:20px']) !!}  
               <div class="col-md-6" id="expire">
                  {!! Form::text('expire',$header->expire?$header->expire:Null
                  , ['class' => 'form-control col-md-6',]) !!}
                  <div class="error-message"> {{ $errors->first('expire') }}</div>
               </div>
                <div class="col-md-6" id="iisla_no">
                  {!! Form::text('iisla_no', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('iisla_no') }}</div>
               </div>
            </div>
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('email1', 'Email 1*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('email1', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('email1') }}</div>
               </div>
            </div>
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('email2', 'Email 2*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('email2', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('email2') }}</div>
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
               {!! Form::label('authorizer_name', 'Authorizer Name*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('authorizer_name', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('authorizer_name') }}</div>
               </div>
            </div>
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('authorizer_education', 'Authorizer Education*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('authorizer_education', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('authorizer_education') }}</div>
               </div>
            </div>
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('authorizer_designation', 'Authorizer Designation*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('authorizer_designation', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('authorizer_designation') }}</div>
               </div>
            </div>
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('report_heading', 'Report Heading*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::text('report_heading', null, ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('report_heading') }}</div>
               </div>
            </div>
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('logo', 'Logo',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::file('logo', ['class' => 'input-file', 'id'=>'logo']) !!}
                  <div class="error-message"> {{ $errors->first('logo') }}</div>
                     <br>
                   <img src="{{asset('image/'.$header->logo)}}" style="max-width:100px;">
               </div>
            </div>
         </div>
		  
         <div class="input submit">
            <div class="col-md-offset-2 col-md-6 submit" style="padding: 0 0 0 24px;">
				<input class="btn btn-success" type="submit" value="Submit">
			 </div>
         </div>
      </div>
      {!! Form::close() !!}
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
@endsection
@section('script')
<script type="text/javascript">
   if($('#ex_validity').val()=='iisla_no'){
         $('#expire').hide();
         $('#iisla_no').show();
      }else{
         $('#iisla_no').hide();
         $('#expire').show();
      }
   $('#ex_validity').change(function() {
      if($(this).val()=='iisla_no'){
         $('#expire').hide();
         $('#iisla_no').show();
      }else{
         $('#iisla_no').hide();
         $('#expire').show();
      }
   })
</script>
@endsection