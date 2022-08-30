@extends('layouts.header')
@section('title', 'Add Notification')
@section('content')
<div id="page-wrapper">
   <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">
               <small>Add Notification</small>
            </h1>
            <ol class="breadcrumb">
               <li>
                  <i class="fa fa-dashboard"></i><a href="{{route('home')}}"> Dashboard</a>                            
               </li>
               <li class="active">
                  <i class="fa fa-edit"></i> Add Notification
               </li>
               <span style="float:right;"><a href="{{ URL::previous() }}"><i class="fa fa-arrow-left"></i> Back</a></span>
            </ol>
         </div>
      </div>
      <section class="content container-fluid">
       @include('layouts.alert')
       </section>
        @php
          $cp_id=null;
          $state[0]="Please First Select Company";
          if(isset($user->state_name)){
           $state[$user->state_id]=$user->state_name;
          }
          $area[0]="Please First Select State";
          if(isset($user->areas_name)){
           $area[$user->areas_id]=$user->areas_name;
          }
          $exec[0]="Please First Select Area";
          if(isset($user->name)){
           $exec[$user->id]=$user->name;
           $cp_id=$comp_id;
          }
         @endphp
      {!!Form::open(['method' => 'POST', 'action' => 'UserNotificationController@store',"id"=>"notificatio_form"]) !!}      
      <div class="row">
         <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('Company Name', 'Company Name*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::Select('valuations_by',$company,$cp_id,['class' => 'form-control col-md-6',"placeholder"=>"Select Company"]) !!}
                  <div class="error-message"> {{ $errors->first('valuations_by') }}</div>
               </div>
            </div>
         </div>
         <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('State', 'State*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::Select('state',$state,isset($user->state_id), ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('name') }}</div>
               </div>
            </div>
         </div>
         <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('area_id', 'Area*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::Select('area_id',$area,isset($user->areas_id),['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('area_id') }}</div>
               </div>
            </div>
         </div>
         <div class="col-lg-12">                 
            <div class="form-group" style="overflow: hidden;">
               {!! Form::label('Mobile Executive', 'Mobile Executive*',['class' => 'col-md-2']) !!}
               <div class="col-md-6">
                  {!! Form::Select('user_id',$exec,isset($user->id), ['class' => 'form-control col-md-6']) !!}
                  <div class="error-message"> {{ $errors->first('user_id') }}</div>
               </div>
            </div>
         </div>
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
         <div class="input submit">
            <div class="submit"><input class="btn btn-default" style="width:100px;font-weight:bold;margin-left:195px" type="submit" ></div>
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
<script>
   $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    $(function() {
        $('select').change(function() {
            var select
            if($(this).attr('name')=='valuations_by'){
               var select = $('form select[name=state]');
               select.html('<option value="0">Select State</option>');
               $('form select[name=user_id]').html('<option value="0">Please First Select Area</option>');
               $('form select[name=area_id]').html('<option value="0">Please First Select State</option>');
            }
            if($(this).attr('name')=='state'){
               var select = $('form select[name=area_id]');
                select.html('<option value="0">Select Area</option>');
               $('form select[name=user_id]').html('<option value="0">Please First Select Area</option>');
            }
            if($(this).attr('name')=='area_id'){
               var select = $('form select[name=user_id]');
                select.html('<option value="0">Select Executive</option>');
            }
            var url = '{{ route("getcomparea")}}'
            formdata=$("#notificatio_form select").serialize()
            $.post(url,formdata,function(data) {
                $.each(data,function(key, value) {
                    select.append('<option value=' + key + '>' + value + '</option>');
                });
            });
        });
    });
</script>
@endsection